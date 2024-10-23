<?php
require_once __DIR__ . '/../../../config/connDatabase.php';
class ProductModel
{
  private $product_id, $name, $stock, $price_in, $price_out, $description, $category_id;
  private $conn;
  public function __construct($product_id = null, $name = null, $stock = null, $price_in = null, $price_out = null, $description = null, $category_id = null)
  {
    $this->product_id = $product_id;
    $this->name = $name;
    $this->stock = $stock;
    $this->price_in = $price_in;
    $this->price_out = $price_out;
    $this->description = $description;
    $this->category_id = $category_id;
    $db = new connDatabase();
    $this->conn = $db->getConnection();
  }


  /**
   * Get the value of product_id
   */
  public function getProduct_id()
  {
    return $this->product_id;
  }

  /**
   * Set the value of product_id
   *
   * @return  self
   */
  public function setProduct_id($product_id)
  {
    $this->product_id = $product_id;

    return $this;
  }

  /**
   * Get the value of name
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Set the value of name
   *
   * @return  self
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * Get the value of stock
   */
  public function getStock()
  {
    return $this->stock;
  }

  /**
   * Set the value of stock
   *
   * @return  self
   */
  public function setStock($stock)
  {
    $this->stock = $stock;

    return $this;
  }

  /**
   * Get the value of price_in
   */
  public function getPrice_in()
  {
    return $this->price_in;
  }

  /**
   * Set the value of price_in
   *
   * @return  self
   */
  public function setPrice_in($price_in)
  {
    $this->price_in = $price_in;

    return $this;
  }

  /**
   * Get the value of price_out
   */
  public function getPrice_out()
  {
    return $this->price_out;
  }

  /**
   * Set the value of price_out
   *
   * @return  self
   */
  public function setPrice_out($price_out)
  {
    $this->price_out = $price_out;

    return $this;
  }

  /**
   * Get the value of description
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Set the value of description
   *
   * @return  self
   */
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get the value of category_id
   */
  public function getCategory_id()
  {
    return $this->category_id;
  }

  /**
   * Set the value of category_id
   *
   * @return  self
   */
  public function setCategory_id($category_id)
  {
    $this->category_id = $category_id;

    return $this;
  }

  public function getRandomProducts()
  {
    $query = 'select product_id, name, price_out, primary_image from products order by rand() limit 8';

    $result = $this->conn->query($query);

    $products = [];
    while ($row = $result->fetch_assoc()) {
      $products[] = $row;
    }

    return $products;
  }

  public function getPaginatedProducts($limit, $page, $sort)
  {
    $offset = ($page - 1) * $limit;

    if ($sort === 'high-to-low') {
      $sort = 'order by price_out asc';
    } elseif ($sort === 'low-to-high') {
      $sort = 'order by price_out desc';
    } else {
      $sort = '';
    }

    $query = "select product_id, name, price_out, primary_image from products $sort limit ? offset ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('ii', $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
      $products[] = $row;
    }
    $stmt->close();
    return $products;
  }

  public function getTotalProducts()
  {
    $query = 'select count(*) from products';
    $result = $this->conn->query($query);
    $totalProducts = $result->fetch_column();

    return $totalProducts;
  }

  public function getProductById($product_id)
  {
    $query = 'select * from products where product_id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('s', $product_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $product = $result->fetch_assoc();
      return $product;
    } else {
      return null;
    }
  }
}
