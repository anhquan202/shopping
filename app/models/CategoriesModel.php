<?php
require_once __DIR__ . '/../../config/connDatabase.php';

class CategoriesModel
{
  private $category_id;
  private $category_name;
  private $conn;
  public function __construct($category_id = null, $category_name = null)
  {
    $this->category_id = $category_id;
    $this->category_name = $category_name;
    $db = new connDatabase();
    $this->conn = $db->getConnection();
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

  public function getCategory_name()
  {
    return $this->category_name;
  }

  /**
   * Set the value of category_name
   *
   * @return  self
   */
  public function setCategory_name($category_name)
  {
    $this->category_name = $category_name;

    return $this;
  }

  //get categories
  public function getCategories() {
    $query = 'SELECT * FROM categories';
    $results = $this->conn->query($query);
    $categories = [];
    while ($category = $results->fetch_assoc()){
      $categories[] = $category;
    }

    return $categories;
  }
}
