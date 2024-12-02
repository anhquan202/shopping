<?php
require_once __DIR__ . '/../models/carts/CartDetailModel.php';
class CartDetailController
{
  private $cartDetailModel;
  public function __construct()
  {
    $this->cartDetailModel = new CartDetailModel();
  }

  public function removeItem()
  {
    try {
      $product_id = $_POST['product_id'];
      $cart_id = $_POST['cart_id'];
      if (!is_numeric($product_id) || !is_numeric($cart_id)) {
        echo json_encode([
          'status' => 400,
          'message' => 'Product ID or Cart ID is invalid'
        ]);
      }
      $result = $this->cartDetailModel->removeItem($product_id, $cart_id);

      header('Content-Type: application/json');
      if ($result) {
        echo json_encode([
          'status' => 200,
          'message' => 'Product removed from cart successfully.'
        ]);
      } else {
        echo json_encode([
          'status' => 200,
          'message' => 'Failed to remove product from cart.'
        ]);
      }
    } catch (\Throwable $th) {
      header('Content-Type: application/json');
      echo json_encode([
        'status' => 500,
        'message' => $th->getMessage(),
        'trace' => $th->getTraceAsString(),
      ]);
    }
  }
}
