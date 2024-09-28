<?php
class connDatabase
{
  private $host = 'localhost';
  private $username = 'root';
  private $password = '';
  private $database = 'shopping';
  private $connection;

  public function __construct()
  {
    $this->connect();
  }

  private function connect()
  {
    $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

    // Kiểm tra kết nối
    if ($this->connection->connect_error) {
      die("Kết nối thất bại: " . $this->connection->connect_error);
    }
  }

  public function getConnection()
  {
    return $this->connection;
  }

  public function closeConnection()
  {
    if ($this->connection) {
      $this->connection->close();
    }
  }
}
