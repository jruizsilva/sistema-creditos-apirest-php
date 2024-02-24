<?php

class Conexion
{
  private $conn;

  public function __construct()
  {
    if (CONNECTION) {
      try {
        $connectionString = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
        $this->conn = new PDO($connectionString, DB_USER, DB_PASSWORD);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Establecer el conjunto de caracteres a UTF-8
        $this->conn->exec("SET NAMES 'utf8'");

      } catch (PDOException $e) {
        echo "Error de conexion: " . $e->getMessage();
      }
    }

  }

  public function getConnection()
  {
    return $this->conn;
  }
}


