<?php
require_once __DIR__ . '/../models/eav-users/UserModel.php';
require_once __DIR__ . '/../models/eav-users/AttributeUserModel.php';
require_once __DIR__ . '/../models/eav-users/ValuesUserModel.php';
class AuthController
{
  private $userModel, $attributeUserModel, $valuesUserModel;
  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->attributeUserModel = new AttributeUserModel();
    $this->valuesUserModel = new ValuesUserModel();
  }

  public function loginPage()
  {
    ob_start();
    require_once __DIR__ . '/../views/login/index.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }
  public function signupPage()
  {
    ob_start();
    require_once __DIR__ . '/../views/signup/index.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }
  public function register()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $full_name = $_POST['full_name'] ?? null;
      $user_phone = $_POST['user_phone'] ?? null;
      $password = $_POST['password'] ?? null;
      $repeat_password = $_POST['repeat_password'] ?? null;

      $data = [
        'full_name' => $full_name,
        'user_phone' => $user_phone,
        'password' => $password,
        'repeat_password' => $repeat_password
      ];

      $result = $this->userModel->register($data);

      if (isset($result['status']) && $result['status'] === 200) {
        $_SESSION['jwt'] = $result['token'];

        header('Content-Type: application/json');
        echo json_encode([
          'success' => 201,
          'message' => 'Register successfully',
          'token' => $result['token']
        ]);
      } else {
        header('Content-Type: application/json');
        echo json_encode([
          'success' => 409,
          'message' => 'Register failed',
          'errors' => $result,
        ]);
      }
    }
  }

  public function signin()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user_phone = $_POST['user_phone'];
      $password = $_POST['password'];

      $data = [
        'user_phone' => $user_phone,
        'password' => $password,
      ];

      $result = $this->userModel->signin($data);

      if (isset($result['status']) && $result['status'] === 200) {
        $_SESSION['jwt'] = $result['token'];

        echo json_encode([
          'status' => 200,
          'message' => 'Sign-in successful',
          'token' => $result['token']
        ]);
      } else {
        echo json_encode($result);
      }
    }
  }
}
