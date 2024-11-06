<?php
require_once __DIR__ . '/../../../config/connDatabase.php';
require_once __DIR__ . '/../JWTModel.php';

class UserModel
{
  private $user_id, $full_name, $user_name, $user_email, $password, $oauth_provider, $oauth_id;
  private $conn;
  private $jwtModel;
  public function __construct($user_id = null, $full_name = null, $user_name = null, $user_email = null, $password = null, $oauth_provider = null, $oauth_id = null)
  {
    $this->user_id = $user_id;
    $this->full_name = $full_name;
    $this->user_name = $user_name;
    $this->user_email = $user_email;
    $this->password = $password;
    $this->oauth_provider = $oauth_provider;
    $this->oauth_id = $oauth_id;
    $db = new connDatabase();
    $this->conn = $db->getConnection();
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
          'full_name' => $full_name,
          'user_phone' => $user_phone
        ];

        $jwt = $this->jwtModel->encodeToken($data);
        return [
          'status' => 200,
          'message' => 'Register successful',
          'token' => $jwt
        ];
      }
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
          $data = [
            "user_id" => $user['user_id'],
            "full_name" => $user['full_name'],
          ];

          $jwt = $this->jwtModel->encodeToken($data);
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
