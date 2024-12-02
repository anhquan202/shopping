<?php
require_once __DIR__ . '/../../../config/connDatabase.php';
class CartDetailModel
{
  private $conn;
  public function __construct()
  {
    $db = new connDatabase();
    $this->conn = $db->getConnection();
  }

  public function removeItem($product_id, $cart_id)
  {
    $query = 'DELETE FROM cart_items WHERE product_id = ? and cart_id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('ii', $product_id, $cart_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      return true;
    } else {
      return false;
    }
  }
}
