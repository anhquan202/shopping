<?php
require_once __DIR__ . '/../../../config/connDatabase.php';
require_once __DIR__ . '/../JWTModel.php';
require_once __DIR__ . '/AttributeUserModel.php';
class UserModel
{
  private $conn;
  private $attributeUserModel, $jwtModel;

  public function __construct()
  {
    $db = new connDatabase();
    $this->conn = $db->getConnection();
    $this->attributeUserModel = new AttributeUserModel();
    $this->jwtModel = new JWTModel();
  }

  public function register($data)
  {
    $full_name = $data['full_name'];
    $user_phone = $data['user_phone'];
    $password = $data['password'];

    $errors = $this->validation($data);
    if (!empty($errors)) {
      return $errors;
    }

    if (!$this->isExistUser($user_phone)) {
      $hash_password = password_hash($password, PASSWORD_DEFAULT);
      $query_insert_user = 'insert into users(full_name, user_phone, password) values (?, ?, ?)';
      $stmt_insert = $this->conn->prepare($query_insert_user);
      $stmt_insert->bind_param('sss', $full_name, $user_phone, $hash_password);
      if ($stmt_insert->execute()) {
        $data = [
          'user_id' => $this->conn->insert_id,
          'full_name' => $full_name,
          'user_phone' => $user_phone
        ];

        $jwt = $this->jwtModel->encodeToken($data);
        return [
          'status' => 200,
          'token' => $jwt
        ];
      } else {
        return [
          'status' => 500,
          'message' => 'User registration failed. Please try again.'
        ];
      }
    } else {
      return [
        'status' => 400,
        'message' => 'User already exists.'
      ];
    }
  }

  public function signin($data)
  {
    $user_phone = $data['user_phone'];
    $password = $data['password'];

    $errors = [];
    $errorsPhone = $this->validateUserPhone($user_phone);
    $errorsPassword = $this->validatePassword($password);
    $errors = array_merge($errors, $errorsPhone, $errorsPassword);

    if (!empty($errors)) {
      return $errors;
    } else {
      $query = 'select * from users where user_phone = ? ';
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('s', $user_phone);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
          $payload = [
            'user_id' => $user['user_id'],
          ];

          $jwt = $this->jwtModel->encodeToken($payload);
          return [
            'status' => 200,
            'token' => $jwt
          ];
        } else {
          return [
            'status' => 401,
            'message' => 'Invalid Password'
          ];
        }
      } else {
        return [
          'status' => 404,
          'message' => 'Invalid Credentials'
        ];
      }
    }
  }

  public function authWithGoogle($data)
  {
    $oauthUser = 'select * from users where oauth_id = ?';
    $stmt = $this->conn->prepare($oauthUser);
    $stmt->bind_param('s', $data['oauth_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      $payload = [
        'user_id' => $user['user_id'],
      ];

      $jwt = $this->jwtModel->encodeToken($payload);
      return [
        'status' => 200,
        'user_id' => $payload['user_id'],
        'token' => $jwt
      ];
    } else {
      $insert_user = 'insert into users (oauth_id, oauth_provider, full_name, user_email, user_phone, avatar) values (?,?,?,?,?,?)';
      $stmt_insert_user = $this->conn->prepare($insert_user);
      $stmt_insert_user->bind_param(
        'ssssss',
        $data['oauth_id'],
        $data['oauth_provider'],
        $data['full_name'],
        $data['user_email'],
        $data['user_phone'],
        $data['avatar']
      );

      if ($stmt_insert_user->execute()) {
        $payload = [
          'user_id' => $this->conn->insert_id,
        ];
        $attributes = $this->attributeUserModel->getUserAttribute();
        foreach ($attributes as $attribute) {
          $insert_user_value = 'insert into user_values (user_id, attribute_id, value) values (?,?,?)';
          $stmt_insert_user_value = $this->conn->prepare($insert_user_value);
          $stmt_insert_user_value->bind_param('iis', $payload['user_id'], $attribute['attribute_id'], $data[$attribute['attribute_name']]);
          $stmt_insert_user_value->execute();
          $stmt_insert_user_value->close();
        }
        $jwt = $this->jwtModel->encodeToken($payload);
        $stmt_insert_user->close();
        return [
          'status' => 201,
          'token' => $jwt
        ];
      } else {
        $stmt_insert_user->close();
        return [
          'status' => 401,
          'message' => 'Unsuccessful Authentication'
        ];
      }
    }
  }

  public function getInfoUser($user_id)
  {
    $query = 'SELECT u.user_id, u.full_name, u.user_phone, u_a.attribute_name, u_v.value from users u
              inner join user_values u_v on u.user_id = u_v.user_id 
              inner join user_attributes u_a on u_v.attribute_id = u_a.attribute_id 
              where u.user_id = ?;';
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = [];
    if ($result->num_rows > 0) {
      $data = $result->fetch_assoc();

      $user['user_id'] = $data['user_id'];
      $user['full_name'] = $data['full_name'];
      $user['user_phone'] = $data['user_phone'];

      $info = [];
      do {
        $info[$data['attribute_name']] = $data['value'];
      } while ($data = $result->fetch_assoc());

      $user['info'] = $info;
    }
    return $user;
  }

  private function isExistUser($user_phone)
  {
    $checkQuery = 'select * from users WHERE user_phone = ?';
    $stmt = $this->conn->prepare($checkQuery);
    $stmt->bind_param('s', $user_phone);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->num_rows > 0;
  }

  private function validation($data)
  {
    $errors = [];

    $errors = array_merge($errors, $this->validateFullName($data['full_name'] ?? null));
    $errors = array_merge($errors, $this->validateUserPhone($data['user_phone'] ?? null));
    $errors = array_merge($errors, $this->validatePassword($data['password'] ?? null, $data['repeat_password'] ?? null));

    return $errors;
  }

  private function validateFullName($full_name)
  {
    $errors = [];
    $regex_fullname = '/^[A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸỳỵỷỹ\s]{2,}$/';

    if (empty($full_name)) {
      $errors['full_name'] = 'Full Name is required.';
    } elseif (!preg_match($regex_fullname, $full_name)) {
      $errors['full_name'] = 'Name Format is incorrect.';
    }

    return $errors;
  }

  private function validateUserPhone($user_phone, $isRegister = false)
  {
    $errors = [];
    $regex_phone = '/^0\d{9,10}$/';

    if ($isRegister && $this->isExistUser($user_phone)) {
      $errors['user_phone'] = 'Phone Number is unique, please re-input Phone Number';
    } elseif (empty($user_phone)) {
      $errors['user_phone'] = 'Phone Number is required.';
    } elseif (!preg_match($regex_phone, $user_phone)) {
      $errors['user_phone'] = 'Phone Number Format is incorrect.';
    }

    return $errors;
  }

  private function validatePassword($password, $repeat_password = null)
  {
    $errors = [];
    $regex_password = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/';

    if (empty($password)) {
      $errors['password'] = 'Password is required.';
    } elseif (!preg_match($regex_password, $password)) {
      $errors['password'] = 'Password must be at least 6 characters, and include both letters and numbers.';
    }
    if ($repeat_password !== null && $password !== $repeat_password) {
      $errors['repeat_password'] = 'Passwords do not match.';
    }

    return $errors;
  }
}
