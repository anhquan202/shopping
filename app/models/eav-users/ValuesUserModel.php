<?php
require_once __DIR__ . '/../../../config/connDatabase.php';

class ValuesUserModel
{
  private $value_id, $user_id, $attribute_id, $value;
  private $conn;
  public function __construct($value_id = null, $user_id = null, $attribute_id = null, $value = null)
  {
    $this->value_id = $value_id;
    $this->user_id = $user_id;
    $this->attribute_id = $attribute_id;
    $this->value = $value;
    $db = new connDatabase();
    $this->conn = $db->getConnection();
  }
}
