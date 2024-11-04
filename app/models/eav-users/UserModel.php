<?php
require_once __DIR__ . '/../../../config/connDatabase.php';

class UserModel
{
  private $user_id, $full_name, $user_name, $user_email, $password, $oauth_provider, $oauth_id;
  private $conn;

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
  }

  public function is_auth()
  {
    return isset($_SESSION['user']);
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

  private function validateUserPhone($user_phone)
  {
    $errors = [];
    $regex_phone = '/^0\d{9,10}$/';

    if (empty($user_phone)) {
      $errors['user_phone'] = 'Phone Number is required.';
    } elseif (!preg_match($regex_phone, $user_phone)) {
      $errors['user_phone'] = 'Phone Number Format is incorrect.';
    }

    return $errors;
  }

  private function validatePassword($password, $repeat_password)
  {
    $errors = [];
    $regex_password = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/';

    if (empty($password) || empty($repeat_password)) {
      $errors['password'] = 'Password is required.';
    } elseif (!preg_match($regex_password, $password)) {
      $errors['password'] = 'Password must be at least 6 characters, and include both letters and numbers.';
    }

    if ($password !== $repeat_password) {
      $errors['repeat_password'] = 'Passwords do not match.';
    }

    return $errors;
  }
}
