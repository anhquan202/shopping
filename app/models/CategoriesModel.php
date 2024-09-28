<?php
class CategoriesModel
{
  private $category_id;
  private $category_name;

  public function __construct($category_id, $category_name)
  {
    $this->category_id = $category_id;
    $this->category_name = $category_name;
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
}
