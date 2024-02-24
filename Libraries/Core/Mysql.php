<?php

class Mysql extends Conexion
{
  private string $query;
  private array $values;

  public function __construct()
  {
    parent::__construct();
  }

  public function insert(string $query, array $values): bool|string
  {
    try {
      $this->query = $query;
      $this->values = $values;
      $stmt = $this->getConnection()->prepare($this->query);
      $resInsert = $stmt->execute($this->values);
      $idInsert = $this->getConnection()->lastInsertId();
      $stmt->closeCursor();
      $resInsert = ($resInsert) ? $idInsert : false;
      return $resInsert;
    } catch (PDOException $e) {
      return "Error " . $e->getMessage() . " Line: " . $e->getLine();
    }
  }

  public function select_all(string $query): array|string
  {
    try {
      $this->query = $query;
      $stmt = $this->getConnection()->prepare($this->query);
      $stmt->execute();
      $resSelectAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $stmt->closeCursor();

      return $resSelectAll;
    } catch (PDOException $e) {
      return "Error " . $e->getMessage() . " Line: " . $e->getLine();
    }
  }

  public function select(string $query, array $values): array|string
  {
    try {
      $this->query = $query;
      $this->values = $values;

      $stmt = $this->getConnection()->prepare($this->query);
      $stmt->execute($this->values);
      $resSelect = $stmt->fetch(PDO::FETCH_ASSOC);
      $stmt->closeCursor();

      return $resSelect;
    } catch (PDOException $e) {
      return "Error " . $e->getMessage() . " Line: " . $e->getLine();
    }
  }

  public function update(string $query, array $values): bool|string
  {
    try {
      $this->query = $query;
      $this->values = $values;

      $stmt = $this->getConnection()->prepare($this->query);
      $resUpdate = $stmt->execute($this->values);
      $stmt->closeCursor();
      return $resUpdate;
    } catch (PDOException $e) {
      return "Error " . $e->getMessage() . " Line: " . $e->getLine();
    }
  }

  public function delete(string $query, array $values): bool|string
  {
    try {
      $this->query = $query;
      $this->values = $values;

      $stmt = $this->getConnection()->prepare($this->query);
      $resDelete = $stmt->execute($this->values);
      $stmt->closeCursor();
      return $resDelete;
    } catch (PDOException $e) {
      return "Error " . $e->getMessage() . " Line: " . $e->getLine();

    }
  }
}