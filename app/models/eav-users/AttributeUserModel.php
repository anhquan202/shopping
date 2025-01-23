<?php
require_once __DIR__ . '/../../../config/connDatabase.php';

class AttributeUserModel
{
  private $conn;
  public function __construct()
  {
    $db = new connDatabase();
    $this->conn = $db->getConnection();
  }
  public function getUserAttribute()
  {
    $query = 'SELECT * FROM user_attributes';
    $stmt = $this->conn->prepare($query);
    $result_map = [];
    if ($stmt->execute()) {
      $result = $stmt->get_result();
      while ($row = $result->fetch_assoc()) {
        $result_map[] = [
          'attribute_name' => $row['attribute_name'],
          'attribute_id' => $row['attribute_id']
        ];
      }
    }
    return $result_map;
  }
}
