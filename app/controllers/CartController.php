<?php
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/eav-product/ProductModel.php';
require_once __DIR__ . '/../models/eav-users/UserModel.php';
class CartController
{
  private $cartModel, $productModel, $userModel;

  public function __construct()
  {
    $this->cartModel = new CartModel();
    $this->productModel = new ProductModel();
    $this->userModel = new UserModel();
  }

  public function index()
  {
    ob_start();
    $cartItem = $this->getCart();
    require_once __DIR__ . '/../views/cart/index.php';

    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }

  public function addToCart()
  {
    try {

      $product_id = $_POST['product_id'];
      $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

      $product = $this->productModel->getProductById($product_id);

      if ($product) {
        $this->cartModel->addToCart($product_id, $quantity);
        $cartItems = $this->cartModel->getCartItems();
        $totalItems = count($cartItems);

        header('Content-Type: application/json');
        echo json_encode([
          'success' => 200,
          'message' => 'Added Product Successfully',
          'count_item' => $totalItems
        ]);
      } else {
        echo json_encode([
          'success' => 404,
          'message' => 'Product not found'
        ]);
      }
    } catch (\Throwable $th) {
      header('Content-Type: application/json');
      echo json_encode([
        'success' => 500,
        'error' => $th->getMessage()
      ]);
    }
  }

  public function getCart()
  {
    $cartItems = $this->cartModel->getCartItems();
    $products = [];

    foreach ($cartItems as $item) {
      $product = $this->productModel->getProductById($item['product_id']);
      if ($product) {
        $product['quantity'] = $item['quantity'];
        $products[] = $product;
      }
    }

    return $products;
  }

  public function counterCart()
  {
    $cart = $this->cartModel->getCartItems();
    $total = count($cart);
    header('Content-Type: application/json');
    echo json_encode([
      'success' => 200,
      'total_items' => $total
    ]);
  }

  public function removeItem()
  {
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
    if (!$product_id) {
      echo json_encode([
        'success' => 400,
        'message' => 'Product ID is missing'
      ]);
      return;
    }

    header('Content-Type: application/json');
    try {
      $is_success = $this->cartModel->removeItem($product_id);
      if ($is_success) {
        echo json_encode([
          'success' => 200,
          'message' => $is_success
        ]);
      }
    } catch (\Throwable $th) {
      echo json_encode([
        'success' => 500,
        'message' => $th->getMessage()
      ]);
    }
  }
}
