<?php
require_once __DIR__ . '/../../../config/connDatabase.php';
class OrderModel
{
  private $conn;
  public function __construct()
  {
    $db = new connDatabase();
    $this->conn = $db->getConnection();
  }

  public function saveOrder($order = [], $cart_products = [], $payment_method)
  {
    try {
      $insert_order = 'INSERT INTO orders(user_id, total_amount) value(?, ?)';
      $order_stmt = $this->conn->prepare($insert_order);
      $order_stmt->bind_param('ii', $order['user_id'], $order['total_amount']);
      $order_stmt->execute();
      $order_id = $this->conn->insert_id;

      $this->addOrderDetail($order_id, $cart_products);

      $this->addOrderPayment($order_id, $payment_method);
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  private function addOrderDetail(int $order_id, $cart_products = [])
  {
    $insert_order_detail = 'INSERT INTO order_details(order_id, product_id, quantity) value(?, ?, ?)';
    $order_detail_stmt = $this->conn->prepare($insert_order_detail);
    foreach ($cart_products as $item) {
      $order_detail_stmt->bind_param('iii', $order_id, $item['product_id'], $item['quantity']);
      $order_detail_stmt->execute();
    }
  }

  private function addOrderPayment($order_id, $payment_method)
  {
    $insert_order_detail = 'INSERT INTO payment(order_id, payment_method) value(?, ?)';
    $order_detail_stmt = $this->conn->prepare($insert_order_detail);
    $order_detail_stmt->bind_param('is', $order_id, $payment_method);
    $order_detail_stmt->execute();
  }
}
