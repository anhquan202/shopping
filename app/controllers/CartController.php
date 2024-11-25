<?php
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/eav-product/ProductModel.php';
require_once __DIR__ . '/../models/eav-users/UserModel.php';
require_once __DIR__ . '/../models/JWTModel.php';
class CartController
{
  private $cartModel, $productModel, $userModel, $jwtModel;

  public function __construct()
  {
    $this->cartModel = new CartModel();
    $this->productModel = new ProductModel();
    $this->userModel = new UserModel();
    $this->jwtModel = new JWTModel();
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
      if (!isset($_COOKIE['auth_token'])) {
        header('Content-Type: application/json');
        echo json_encode([
          'success' => 403,
          'message' => 'You need to register or login!'
        ]);
      } else {
        $user_id = $this->getUserId();
        $product_id = $_POST['product_id'];
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
        $product = $this->productModel->getProductById($product_id);

        if ($product) {
          $this->cartModel->addToCart($user_id, $product_id, $quantity);
          $cartItems = $this->cartModel->getCartItems($user_id);
          $totalItems = count($cartItems);

          header('Content-Type: application/json');
          echo json_encode([
            'success' => 200,
            'message' => 'Added Product Successfully',
            'count_item' => $totalItems
          ]);
        }
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
    $user_id = $this->getUserId();
    $cartItems = $this->cartModel->getCartItems($user_id);
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
    $user_id = $this->getUserId();
    $cart = $this->cartModel->getCartItems($user_id);
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
      $user_id = $this->getUserId();
      print_r($user_id);
      $is_success = $this->cartModel->removeItem($user_id, $product_id);
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

  //decode jwt_token to get user_id
  private function getUserId()
  {
    if (isset($_COOKIE['auth_token'])) {
      $jwt_token = $_COOKIE['auth_token'];
      $decoded_token = $this->jwtModel->decodeToken($jwt_token);
      return $decoded_token->user_id ?? null;
    }
  }
}
