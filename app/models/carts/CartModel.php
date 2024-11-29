<?php
require_once __DIR__ . '/../../models/eav-product/ProductModel.php';
require_once __DIR__ . '/../../../config/connDatabase.php';
class CartModel
{
  private $cart_id, $user_id, $status;
  private $productModel;
  private $conn;
  public function __construct($cart_id = null, $user_id = null, $status = 'draft')
  {
    $this->cart_id = $cart_id;
    $this->user_id = $user_id;
    $this->status = $status;
    $this->productModel = new ProductModel();
    $db = new connDatabase();
    $this->conn = $db->getConnection();
  }
  public function addToCart($user_id, $product_id, $quantity)
  {
    $check_cart = 'SELECT cart_id FROM carts WHERE user_id = ?';
    $stmt_check = $this->conn->prepare($check_cart);
    $stmt_check->bind_param('i', $user_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
      $cart = $result->fetch_assoc();
      $cart_id = $cart['cart_id'];
    } else {
      $insert_cart = 'INSERT INTO carts(user_id) VALUES (?)';
      $stmt = $this->conn->prepare($insert_cart);
      $stmt->bind_param('i', $user_id);
      $stmt->execute();
      $cart_id = $stmt->insert_id;
    }

    $check_cart_detail = 'SELECT ci.quantity, prs.stock 
                            FROM cart_items ci 
                            JOIN products prs ON ci.product_id = prs.product_id 
                            WHERE ci.cart_id = ? AND ci.product_id = ?';
    $stmt_detail_check = $this->conn->prepare($check_cart_detail);
    $stmt_detail_check->bind_param('ii', $cart_id, $product_id);
    $stmt_detail_check->execute();
    $result_detail = $stmt_detail_check->get_result();

    if ($result_detail->num_rows > 0) {
      $cart_detail = $result_detail->fetch_assoc();
      $new_quantity = $cart_detail['quantity'] + $quantity;

      if ($new_quantity > $cart_detail['stock']) {
        return [
          'status' => 403,
          'message' => 'Quantity exceeds stock. Available stock: ' . $cart_detail['stock']
        ];
      } else {
        $update_cart_detail = 'UPDATE cart_items SET quantity = ? WHERE product_id = ? AND cart_id = ?';
        $stmt_update = $this->conn->prepare($update_cart_detail);
        $stmt_update->bind_param('iii', $new_quantity, $product_id, $cart_id);
        $stmt_update->execute();

        return [
          'status' => 200,
          'message' => 'Cart updated successfully'
        ];
      }
    } else {
      $check_stock = 'SELECT stock FROM products WHERE product_id = ?';
      $stmt_stock = $this->conn->prepare($check_stock);
      $stmt_stock->bind_param('i', $product_id);
      $stmt_stock->execute();
      $result_stock = $stmt_stock->get_result();
      $product = $result_stock->fetch_assoc();

      if ($quantity > $product['stock']) {
        return [
          'status' => 403,
          'message' => 'Quantity exceeds stock. Available stock: ' . $product['stock']
        ];
      } else {
        $insert_cart_detail = 'INSERT INTO cart_items(cart_id, product_id, quantity) VALUES (?, ?, ?)';
        $stmt_insert_detail = $this->conn->prepare($insert_cart_detail);
        $stmt_insert_detail->bind_param('iii', $cart_id, $product_id, $quantity);
        $stmt_insert_detail->execute();

        return [
          'status' => 200,
          'message' => 'Product added to cart successfully'
        ];
      }
    }
  }

  public function getCart($user_id)
  {
    $query = 'SELECT * FROM carts c INNER JOIN cart_items ci ON c.cart_id = ci.cart_id where user_id = ?';
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
      die('Query Error: ' . $this->conn->error);
    }

    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $cart_items = [];
    if ($row = $result->fetch_assoc()) {
      $cart_items[] = $row;
    }
    return $cart_items;
  }
}
