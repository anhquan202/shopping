<?php
require_once __DIR__ . '/../models/eav-product/ProductModel.php';
require_once __DIR__ . '/../models/eav-product/ValuesProductModel.php';
require_once __DIR__ . '/../models/eav-product/FriendlyLabels.php';
class ProductDetailController
{
  private $productModel, $valuesProductModel;
  public function __construct()
  {
    $this->productModel = new ProductModel();
    $this->valuesProductModel = new ValuesProductModel();
  }

  public function index()
  {
    ob_start();
    $productById = $this->getProductById();
    $detailProduct = $this->getProductDetail();
    require_once __DIR__ . '/../views/productDetail/index.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }

  public function getProductById()
  {
    $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';
    return $this->productModel->getProductById($product_id);
  }

  public function getProductDetail()
  {
    $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';
    $detailProduct = $this->valuesProductModel->getValuesProduct($product_id);
    $friendlyLabels = FriendlyLabels::getLabels();
    $friendlyDetailProduct = [];
    foreach ($detailProduct as $info) {
      $key = $info['attribute_name'];
      $friendlyKey = isset($friendlyLabels[$key]) ? $friendlyLabels[$key] : $key;
      $friendlyDetailProduct[] = [
        'attribute_name' => $friendlyKey,
        'value' => $info['value']
      ];
    }

    return $friendlyDetailProduct;
  }
}
