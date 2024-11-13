<?php
require_once __DIR__ . '/../models/eav-product/ProductModel.php';
class CartModel
{
  private $productModel;
  public function __construct()
  {
    $this->productModel = new ProductModel();
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }
  }
  public function addToCart($product_id, $quantity)
  {
    if (isset($_SESSION['cart'][$product_id])) {
      $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
      $_SESSION['cart'][$product_id] = [
        'product_id' => $product_id,
        'quantity' => $quantity,
      ];
    }
  }

  public function getCartItems()
  {
    return  $_SESSION['cart'];
  }

  public function removeItem($product_id)
  {
    if ($_SESSION['cart'][$product_id]) {
      unset($_SESSION['cart'][$product_id]);
      return true;
    } else {
      return false;
    }
  }

  public function getTotalPrice()
  {
    $cartItems = $this->getCartItems();
    $total = 0;

    foreach ($cartItems as $item) {
      $product = $this->productModel->getProductById($item['product_id']);
      $total += $product['price_out'] * $item['quantity'];
    }

    return $total;
  }
}
