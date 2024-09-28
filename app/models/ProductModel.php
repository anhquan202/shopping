<?php
class ProductModel
{
  private $product_id, $name, $stock, $price_in, $price_out, $decription, $category_id;
  public function __construct($product_id, $name, $stock, $price_in, $price_out, $decription, $category_id)
  {
    $this->product_id = $product_id;
    $this->name = $name;
    $this->stock = $stock;
    $this->price_in = $price_in;
    $this->price_out = $price_out;
    $this->decription = $decription;
    $this->category_id = $category_id;
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
   * Get the value of decription
   */
  public function getDecription()
  {
    return $this->decription;
  }

  /**
   * Set the value of decription
   *
   * @return  self
   */
  public function setDecription($decription)
  {
    $this->decription = $decription;

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
}
