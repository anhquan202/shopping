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
