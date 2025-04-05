<?php
require_once __DIR__ . '/../../config/connDatabase.php';
class Model
{
  protected $conn;
  public function __construct()
  {
    $db = new connDatabase();
    $this->conn = $db->getConnection();
  }
  // get all data from table
  public function all($table)
  {
    try {
      $sql = "SELECT * FROM $table";
      $stmt = $this->conn->prepare($sql);
      if (!$stmt) {
        throw new Exception($this->conn->error);
      } else {
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
      }
    } catch (\Throwable $th) {
      die($th->getMessage());
    }
  }

  //get data with condition
  public function where($table, $conditions)
  {
    $conditionStr = implode(" AND ", array_map(function ($key) {
      return "$key=?";
    }, array_keys($conditions)));

    $values = array_values($conditions);
    $types = str_repeat('s', count($values)); // Assuming all values are strings

    try {
      $sql = "SELECT * FROM $table WHERE $conditionStr";
      $stmt = $this->conn->prepare($sql);
      if (!$stmt) {
        throw new Exception($this->conn->error);
      } else {
        $stmt->bind_param($types, ...$values);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
      }
    } catch (\Throwable $th) {
      die($th->getMessage());
    }
  }

  // insert data into table
  public function insert($table, $data)
  {
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), '?'));
    $values = array_values($data);
    $types = str_repeat('s', count($data)); // Assuming all values are strings
    try {
      $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
      $stmt = $this->conn->prepare($sql);
      if (!$stmt) {
        throw new Exception($this->conn->error);
      } else {
        $stmt->bind_param($types, ...$values);
        return $stmt->execute();
      }
    } catch (\Throwable $th) {
      die($th->getMessage());
    }
  }

  // update data in table
  public function update($table, $data, $conditions)
  {
    $setStr = implode(", ", array_map(function ($key) {
      return "$key=?";
    }, array_keys($data)));

    $conditionStr = implode(" AND ", array_map(function ($key) {
      return "$key=?";
    }, array_keys($conditions)));

    $values = array_merge(array_values($data), array_values($conditions));
    $types = str_repeat('s', count($values)); // Assuming all values are strings

    try {
      $sql = "UPDATE $table SET $setStr WHERE $conditionStr";
      $stmt = $this->conn->prepare($sql);
      if (!$stmt) {
        throw new Exception($this->conn->error);
      } else {
        $stmt->bind_param($types, ...$values);
        return $stmt->execute();
      }
    } catch (\Throwable $th) {
      die($th->getMessage());
    }
  }

  // delete data from table
  public function delete($table, $conditions)
  {
    $conditionStr = implode(" AND ", array_map(function ($key) {
      return "$key=?";
    }, array_keys($conditions)));

    $values = array_values($conditions);
    $types = str_repeat('s', count($values)); // Assuming all values are strings

    try {
      $sql = "DELETE FROM $table WHERE $conditionStr";
      $stmt = $this->conn->prepare($sql);
      if (!$stmt) {
        throw new Exception($this->conn->error);
      } else {
        $stmt->bind_param($types, ...$values);
        return $stmt->execute();
      }
    } catch (\Throwable $th) {
      die($th->getMessage());
    }
  }
}
