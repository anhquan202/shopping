<?php
require_once __DIR__ . '/../../../config/connDatabase.php';

class AttributeUserModel
{
  private $attribute_id, $attribute_name;
  public function __construct($attribute_id = null, $attribute_name = null)
  {
    $this->attribute_id = $attribute_id;
    $this->attribute_name = $attribute_name;
  }
}
