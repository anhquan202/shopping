<?php
class CheckoutController
{
  public function index()
  {
    ob_start();
    require_once __DIR__ . '/../views/checkout/index.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }
}
