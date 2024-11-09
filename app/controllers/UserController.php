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
        echo json_encode($user);
      } catch (\Throwable $th) {
        echo json_encode([
          'message' => $th->getMessage()
        ]);
      }
    }
  }
}
