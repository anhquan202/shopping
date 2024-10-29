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
}
