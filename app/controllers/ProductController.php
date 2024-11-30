<?php
require_once __DIR__ . '/../models/eav-product/ProductModel.php';
class ProductController
{
  private $productModel;
  public function __construct()
  {
    $this->productModel = new ProductModel();
  }

  public function index()
  {
    ob_start();
    // set data-page for loading file js
    $data_page = 'products';

    $paginations = $this->showPaginatedProducts();
    $products = $paginations['products'];
    $totalPages = $paginations['totalPages'];
    $pages = $paginations['pages'];
    $sort = $paginations['sort'];

    require_once __DIR__ . '/../views/products/index.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }

  public function showPaginatedProducts()
  {
    $limit = 12;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $totalProducts = $this->productModel->getTotalProducts();

    $totalPages = ceil($totalProducts / $limit);

    $products = $this->productModel->getPaginatedProducts($limit, $page, $sort);

    return [
      'products' => $products,
      'totalPages' => $totalPages,
      'pages' => $page,
      'sort' => $sort
    ];
  }
}
