<?php

class FrecuenciaModel extends Mysql
{
  public function __construct()
  {
    parent::__construct();
  }

  public function findById(string $id_frecuencia): array|string
  {
    $sqlSelect = "SELECT id_frecuencia, frecuencia, DATE_FORMAT(date_created, '%d-%m-%Y') as fecha_registro FROM frecuencias WHERE id_frecuencia = :id_frecuencia AND status = 1";
    $valuesSelect = [
      'id_frecuencia' => $id_frecuencia,
    ];
    $frecuencia = $this->select($sqlSelect, $valuesSelect);
    return $frecuencia;

  }

  public function findAll(): array
  {
    $sqlSelect = "SELECT * FROM frecuencias WHERE status = 1";
    $frecuencias = $this->select_all($sqlSelect);
    return $frecuencias;
  }

  public function save(string $frecuencia): bool|string
  {
    $sqlInsert = "INSERT INTO frecuencias (frecuencia) VALUES (:frecuencia);";
    $valuesInsert = [
      'frecuencia' => $frecuencia,
    ];
    $save = $this->insert($sqlInsert, $valuesInsert);
    return $save;
  }

  public function updateFrecuencia(string $id_frecuencia, string $frecuencia): bool|string
  {
    $sqlUpdate = "UPDATE frecuencias SET frecuencia = :frecuencia WHERE id_frecuencia = :id_frecuencia";
    $valuesUpdate = [
      'id_frecuencia' => $id_frecuencia,
      'frecuencia' => $frecuencia,
    ];
    $resUpdate = $this->update($sqlUpdate, $valuesUpdate);
    return $resUpdate;
  }

  public function deleteFrecuencia(string $id_frecuencia): bool|string
  {
    $sqlDelete = "UPDATE frecuencias SET status = 0 WHERE id_frecuencia = :id_frecuencia";
    $valuesDelete = [
      'id_frecuencia' => $id_frecuencia,
    ];
    $resDelete = $this->update($sqlDelete, $valuesDelete);
    return $resDelete;
  }
}
