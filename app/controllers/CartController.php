<?php
require_once __DIR__ . '/../models/carts/CartModel.php';
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
    // set data-page for loading file js
    $data_page = 'carts';

    $carts = $this->getCart();
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
          'status' => 401,
          'message' => 'Unauthorized: Authentication required.',
        ]);
        return;
      } else {
        $user_id = $this->getUserId();
        $product_id = $_POST['product_id'];
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

        $result = $this->cartModel->addToCart($user_id, $product_id, $quantity);
        header('Content-Type: application/json');
        echo json_encode([
          'status' => $result['status'],
          'message' => $result['message'],
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

  public function getCart()
  {
    $user_id = $this->getUserId();
    $cart_items = $this->cartModel->getCart($user_id);

    $cart_data = [];
    if (!empty($cart_items)) {
      $cart_id = $cart_items[0]['cart_id'];
      $cart_data['cart_id'] = $cart_id;

      $cart_data['products'] = [];

      $total_amount = 0;
      foreach ($cart_items as $item) {
        if (isset($item['product_id'])) {
          $product = $this->productModel->getProductById($item['product_id']);
          if ($product) {
            $product['quantity'] = $item['quantity'];
            $total_amount += $item['quantity'] * $product['price_out'];
            $cart_data['products'][] = $product;
          }
        }
      }
      $cart_data['total_amount'] = $total_amount;
    }

    return $cart_data;
  }


  public function counterCart()
  {
    $user_id = $this->getUserId();
    $cart = $this->cartModel->getCart($user_id);
    $total = count($cart);
    header('Content-Type: application/json');
    echo json_encode([
      'status' => 200,
      'total_items' => $total
    ]);
  }

  //decode jwt_token to get user_id
  public function getUserId()
  {
    if (isset($_COOKIE['auth_token'])) {
      $jwt_token = $_COOKIE['auth_token'];
      $decoded_token = $this->jwtModel->decodeToken($jwt_token);
      return $decoded_token->data->user_id;
    }
  }
}
