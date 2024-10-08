<?php
require_once __DIR__ . '/../../config/connDatabase.php';
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
    $query = 'select products.product_id, products.name, products.price_out, product_values.value 
              from products inner join product_values on products.product_id = product_values.product_id 
              where attribute_id = 18 limit 8;';
              
    $result = $this->conn->query($query);

    $products = [];
    while ($row = $result->fetch_assoc()) {
      $products[] = $row;
    }

    return $products;
  }
}
