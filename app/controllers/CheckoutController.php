<?php
require_once __DIR__ .  '/../controllers/CartController.php';
require_once __DIR__ . '/../models/orders/OrderModel.php';
require_once __DIR__ . '/../models/JWTModel.php';
class CheckoutController
{
  private $orderModel, $jwtModel;
  private $cartController;
  public function __construct()
  {
    $this->orderModel = new OrderModel();
    $this->jwtModel = new JWTModel();
    $this->cartController = new CartController();
  }
  public function index()
  {
    ob_start();
    $data_page = 'checkout';
    $carts = $this->getCart();
    require_once __DIR__ . '/../views/checkout/index.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }
  public function getCart()
  {
    return $this->cartController->getCart();
  }

  public function checkoutByVNPay()
  {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $startTime = date("YmdHis");
    $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "http://localhost:8081/shopping/thanks";
    $vnp_TmnCode = "CGXZLS0Z"; //Mã website tại VNPAY 
    $vnp_HashSecret = "XNBCJFAKAZQSGTARRLGCHVZWCIOIGSHN"; //Chuỗi bí mật


    $vnp_TxnRef = rand(1, 10000); //Mã giao dịch thanh toán tham chiếu của merchant
    $vnp_Amount = $_POST['amount']; // Số tiền thanh toán
    $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
    $vnp_BankCode = $_POST['bankcode'] || ""; //Mã phương thức thanh toán
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

    $inputData = array(
      "vnp_Version" => "2.1.0",
      "vnp_TmnCode" => $vnp_TmnCode,
      "vnp_Amount" => $vnp_Amount * 100,
      "vnp_Command" => "pay",
      "vnp_CreateDate" => date('YmdHis'),
      "vnp_CurrCode" => "VND",
      "vnp_IpAddr" => $vnp_IpAddr,
      "vnp_Locale" => $vnp_Locale,
      "vnp_OrderInfo" => "Thanh toan hoa don",
      "vnp_OrderType" => "other",
      "vnp_ReturnUrl" => $vnp_Returnurl,
      "vnp_TxnRef" => $vnp_TxnRef,
      "vnp_ExpireDate" => $expire,
    );

    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
      $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    // var_dump($inputData);
    // die();
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
      if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
      } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
      }
      $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
      $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
      $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    // header('Location: ' . $vnp_Url);
    // die();
    $returnData = array(
      'code' => '00',
      'message' => 'success',
      'data' => $vnp_Url
    );
    if (isset($_POST['redirect'])) {
      header('Location: ' . $vnp_Url);
      die();
    } else {
      echo json_encode($returnData);
    }
  }

  public function thankyou()
  {
    ob_start();
    $data_page = 'thank you';
    $this->saveOrder();
    require_once __DIR__ . '/../views/thanks/index.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }
  public function saveOrder()
  {
    $cart = $this->getCart();
    $total_amount = $cart['total_amount'] ?? 0;

    if (empty($cart['products']) || $total_amount <= 0) {
      throw new Exception("Cart is empty or total amount is invalid.");
    }

    if (!isset($_COOKIE['auth_token'])) {
      throw new Exception("User is not authenticated.");
    }

    $jwt_token = $_COOKIE['auth_token'];
    $decode = $this->jwtModel->decodeToken($jwt_token);

    if (!isset($decode->data->user_id)) {
      throw new Exception("Invalid JWT token.");
    }

    $user_id = $decode->data->user_id;

    $payment_method = $_GET['vnp_CardType'] ?? $_GET['payment_method'] ?? null;
    if (empty($payment_method)) {
      throw new Exception("Payment method is not specified.");
    }

    $order = [
      'user_id' => $user_id,
      'total_amount' => $total_amount
    ];

    $cart_products = $cart['products'];
    $this->orderModel->saveOrder($order, $cart_products, $payment_method);
  }
}
