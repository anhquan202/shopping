<?php
require_once __DIR__ . '/../models/JWTModel.php';
require_once __DIR__ . '/../models/eav-users/UserModel.php';
class UserController
{
  private $jwtModel, $userModel;
  public function __construct()
  {
    $this->jwtModel = new JWTModel();
    $this->userModel = new UserModel();
  }

  public function index()
  {
    ob_start();
    $data_page = 'complete-profile';
    if (isset($_SESSION['tempo_user_info'])) {
      $data = $_SESSION['tempo_user_info'];
    }
    require_once __DIR__ . '/../views/user/complete-profile.php';

    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }

  public function completeProfileUserAfterOauth()
  {
    try {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $full_name = $_POST['full_name'] ?? $_SESSION['tempo_user_info']['full_name'];
        $user_phone = $_POST['user_phone'] ?? null;
        $address = $_POST['address'] ?? null;
        if (isset($_SESSION['tempo_user_info'])) {
          $_SESSION['tempo_user_info'] = array_merge(
            $_SESSION['tempo_user_info'],
            [
              'full_name' => $full_name,
              'user_phone' => $user_phone,
              'address' => $address
            ]
          );
          $data = $_SESSION['tempo_user_info'];
          $result = $this->userModel->authWithGoogle($data);
          if (isset($result['status']) && $result['status'] === 201) {
            setcookie(
              'auth_token',
              $result['token'],
              time() + 36000,
              '/',
              '',
              true,
              true
            );

            header('Content-Type: application/json');
            echo json_encode([
              'status' => $result['status'],
              'message' => 'Completed! You logged in successfull!',
            ]);
          }
        } else {
          header('Content-Type: application/json');
          echo json_encode([
            'status' => 401,
            'error' => 'Failed',
          ]);
        }
      }
    } catch (\Throwable $th) {
      http_response_code(500);
      header('Content-Type: application/json');
      echo json_encode([
        'status' => 500,
        'message' => $th->getMessage(),
        'trace' => $th->getTraceAsString(),
      ]);
    }
  }
  public function getUserInfo()
  {
    try {
      if (isset($_COOKIE['auth_token'])) {
        $jwt_token = $_COOKIE['auth_token'];
        $decode = $this->jwtModel->decodeToken($jwt_token);
        $user_id = $decode->data->user_id;
        $user = $this->userModel->getInfoUser($user_id);
        if ($user) {
          http_response_code(200);
          header('Content-Type: application/json');
          echo json_encode([
            'status' => 201,
            'user' => $user
          ]);
        } else {
          http_response_code(404);
          header('Content-Type: application/json');
          echo json_encode([
            'status' => 404,
            'message' => 'User not found'
          ]);
        }
      } else {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode([
          'status' => 400,
          'message' => 'User is not authenticated'
        ]);
      }
    } catch (\Throwable $th) {
      http_response_code(500);
      header('Content-Type: application/json');
      echo json_encode([
        'status' => 500,
        'message' => $th->getMessage(),
        'trace' => $th->getTraceAsString(),
      ]);
    }
  }
}
