<?php
require_once __DIR__ . '/../controllers/CartController.php';
require_once __DIR__ . '/../models/orders/OrderModel.php';
require_once __DIR__ . '/../models/JWTModel.php';
class ThankyouController
{
  private $cartController, $jwtModel, $orderModel;
  public function __construct()
  {
    $this->cartController = new CartController();
    $this->jwtModel = new JWTModel();
    $this->orderModel = new OrderModel();
  }
  public function index()
  {
    ob_start();
    $data_page = 'thanks';
    require_once __DIR__ . '/../views/thanks/index.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }

  public function saveOrder()
  {
    try {
      $cart = $this->getCart();
      if (empty($cart)) {
        return;
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $receiver_address = $_POST['receiver_address'];
        $receiver_name = $_POST['receiver_name'];
        $receiver_phone = $_POST['receiver_phone'];
        $payment_method = $_POST['payment_method'];
      } else {
        return;
      }

      if (empty($receiver_address) || empty($receiver_name) || empty($receiver_phone) || empty($payment_method)) {
        return;
      }

      $order = [
        'user_id' => $cart['user_id'],
        'total_amount' => $cart['total_amount'],
        'receiver_address' => $receiver_address,
        'receiver_name' => $receiver_name,
        'receiver_phone' => $receiver_phone,
        'cart_products' => $cart['cart_products']
      ];

      $this->orderModel->saveOrder($order, $cart['cart_products'], $payment_method);
      http_response_code(200);
      echo json_encode([
        'status' => 200,
        'message' => 'Order saved successfully.',
      ]);
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
  private function getCart()
  {
    try {
      if (!isset($_COOKIE['auth_token'])) {
        error_log("User is not authenticated.");
        return;
      }

      $jwt_token = $_COOKIE['auth_token'];
      $decode = $this->jwtModel->decodeToken($jwt_token);
      $user_id = $decode->data->user_id;

      $cart = $this->cartController->getCart();
      return [
        'user_id' => $user_id,
        'cart_products' => $cart['products'],
        'total_amount' => $cart['total_amount']
      ];
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }
}
