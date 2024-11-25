<?php
require_once __DIR__ . '/../models/eav-product/ProductModel.php';
require_once __DIR__ . '/../../config/connDatabase.php';
class CartModel
{
  private $productModel;
  private $conn;
  public function __construct()
  {
    $this->productModel = new ProductModel();
    $db = new connDatabase();
    $this->conn = $db->getConnection();

    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }
  }
  public function addToCart($user_id, $product_id, $quantity)
  {
    if (!isset($_SESSION['cart'][$user_id])) {
      $_SESSION['cart'][$user_id] = [];
    }
    if (isset($_SESSION['cart'][$user_id][$product_id])) {
      $_SESSION['cart'][$user_id][$product_id]['quantity'] += $quantity;
    } else {
      $_SESSION['cart'][$user_id][$product_id] = [
        'user_id' => $user_id,
        'product_id' => $product_id,
        'quantity' => $quantity,
      ];
    }
  }

  public function getCartItems($user_id)
  {
    return $_SESSION['cart'][$user_id] ?? [];
  }

  public function removeItem($user_id, $product_id)
  {
    if ($_SESSION['cart'][$user_id][$product_id]) {
      unset($_SESSION['cart'][$user_id][$product_id]);
      return true;
    } else {
      return false;
    }
  }
  public function getCartItemCount($user_id)
  {
    if (isset($_SESSION['cart'][$user_id])) {
      return count($_SESSION['cart'][$user_id]);
    }
    return 0;
  }
  public function clearCart($user_id)
  {
    if (isset($_SESSION['cart'][$user_id])) {
      unset($_SESSION['cart'][$user_id]);
    }
  }
}
