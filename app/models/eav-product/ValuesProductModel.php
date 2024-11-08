<?php
require_once __DIR__ . '/../../../config/connDatabase.php';
class ValuesProductModel
{
  private $value_id, $product_id, $attribute_id, $value;
  private $conn;
  public function __construct($value_id = null, $product_id = null, $attribute_id = null, $value = null)
  {
    $this->value_id = $value_id;
    $this->product_id = $product_id;
    $this->attribute_id = $attribute_id;
    $this->value = $value;
    $db = new connDatabase();
    $this->conn = $db->getConnection();
  }

  /**
   * Get the value of value
   */
  public function getValue()
  {
    return $this->value;
  }

  /**
   * Set the value of value
   *
   * @return  self
   */
  public function setValue($value)
  {
    $this->value = $value;

    return $this;
  }

  public function getValuesProduct($product_id)
  {
    $query = "select product_attributes.attribute_name, product_values.value from product_attributes 
              inner join product_values on product_attributes.attribute_id = product_values.attribute_id where product_id=? and value !='' ";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $detailProduct = [];
    while ($row = $result->fetch_assoc()) {
      $detailProduct[] = $row;
    }
    return $detailProduct;
  }
}
