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
    if (isset($_COOKIE['auth_token'])) {
      $jwt_token = $_COOKIE['auth_token'];
      try {
        $user = $this->jwtModel->decodeToken($jwt_token);

        header('Content-Type: application/json');
        echo json_encode([
          'status' => 201,
          'user' => $user
        ]);
      } catch (\Throwable $th) {
        header('Content-Type: application/json');
        echo json_encode([
          'message' => $th->getMessage()
        ]);
      }
    }
  }
}
