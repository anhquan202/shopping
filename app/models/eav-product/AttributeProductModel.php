<?php
require_once __DIR__  . '/../../../config/connDatabase.php';
class AttributeProductModel
{

  private $attribute_id, $attribute_name;
  private $conn;
  public function __construct($attribute_id, $attribute_name)
  {
    $this->attribute_id = $attribute_id;
    $this->attribute_name = $attribute_name;
    $db = new connDatabase();
    $this->conn = $db->getConnection();
  }

  /**
   * Get the value of attribute_name
   */
  public function getAttribute_name()
  {
    return $this->attribute_name;
  }

  /**
   * Set the value of attribute_name
   *
   * @return  self
   */
  public function setAttribute_name($attribute_name)
  {
    $this->attribute_name = $attribute_name;

    return $this;
  }
}
