<?php
require_once __DIR__ . '/../models/CategoriesModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
class HomeController{
  private $categoriesModel, $productModel;
  public function __construct() {
    $this->categoriesModel = new CategoriesModel(null, null);
    $this->productModel = new ProductModel();
  }

  public function index() {
    ob_start();
    $categories = $this->categoriesModel->getCategories();
    require_once __DIR__ . '/../views/home/index.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }
}