<?php

class TipoMovimientoModel extends Mysql
{
  private string $id_tipo_movimiento;
  private string $movimiento;
  private string $tipo_movimiento;
  private string $descripcion_tipo_movimiento;

  private string $id_movimiento;
  private string $cuenta_id;
  private string $descripcion;
  private string $monto;
  private string $fecha;

  public function __construct()
  {
    parent::__construct();
  }

  public function findByMovimiento(string $tipo_movimiento)
  {
    $sqlSelect = "SELECT * FROM tipo_movimientos WHERE movimiento = :movimiento AND status != 0";
    $valuesSelect = [
      'movimiento' => $tipo_movimiento
    ];
    $tipo_movimiento = $this->select($sqlSelect, $valuesSelect);

    return $tipo_movimiento;
  }

  public function save(string $movimiento, string $tipo_movimiento, string $descripcion)
  {
    $this->movimiento = $movimiento;
    $this->tipo_movimiento = $tipo_movimiento;
    $this->descripcion = $descripcion;

    $sqlInsert = "INSERT INTO tipo_movimientos (movimiento, tipo_movimiento, descripcion) VALUES (:movimiento, :tipo_movimiento, :descripcion)";
    $insertValues = [
      'movimiento' => $this->movimiento,
      'tipo_movimiento' => $this->tipo_movimiento,
      'descripcion' => $this->descripcion
    ];
    $resInsert = $this->insert($sqlInsert, $insertValues);
    return $resInsert;
  }

  public function findAll()
  {
    $sqlSelect = "SELECT id_tipo_movimiento, movimiento, tipo_movimiento FROM tipo_movimientos WHERE status != 0 ORDER BY id_tipo_movimiento DESC";
    $tipo_movimientos = $this->select_all($sqlSelect);
    return $tipo_movimientos;
  }
}
