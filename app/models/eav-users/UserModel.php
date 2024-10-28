<?php
require_once __DIR__ . '/../../../config/connDatabase.php';
class UserModel
{
  private $user_id, $name, $email, $password;
  private $conn;
  public function __construct($user_id = null, $name = null, $email = null, $password = null)
  {
    $this->user_id = $user_id;
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
    $db = new connDatabase();
    $this->conn = $db->getConnection();
  }

  /**
   * Get the value of password
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   *
   * @return  self
   */
  public function setPassword($password)
  {
    $this->password = password_hash($password, PASSWORD_DEFAULT);;

    return $this;
  }


  public function is_auth()
  {
    return isset($_SESSION['user']);
  }
}
