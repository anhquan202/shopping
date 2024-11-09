<?php
require_once './vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTModel
{
  private $secret_key;
  private $expiration_time;
  public function __construct()
  {
    $this->secret_key = "123451331321";
    $this->expiration_time = time() + 3600;
  }
  public function encodeToken($data)
  {
    $payload = [
      "exp" => $this->expiration_time,
      "data" => $data
    ];
    return JWT::encode($payload, $this->secret_key, 'HS256');
  }
  public function decodeToken($token)
  {
    return JWT::decode($token, new Key($this->secret_key, 'HS256'));
  }
}
