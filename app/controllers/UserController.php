<?php
require_once __DIR__ . '/../models/JWTModel.php';
class UserController
{
  private $jwtModel;
  public function __construct()
  {
    $this->jwtModel = new JWTModel();
  }
  public function getUserInfo()
  {
    try {
      if (isset($_COOKIE['auth_token'])) {
        $jwt_token = $_COOKIE['auth_token'];
        $user = $this->jwtModel->decodeToken($jwt_token);

        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode([
          'status' => 201,
          'user' => $user
        ]);
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
