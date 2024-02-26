<?php

class CuentaModel extends Mysql
{
  private string $id_cuenta;
  private string $cliente_id;
  private string $producto_id;
  private string $frecuencia_id;
  private string $monto;
  private string $cuotas;
  private string $monto_cuotas;
  private string $cargo;
  private string $saldo;

  public function __construct()
  {
    parent::__construct();
  }

  public function create(string $cliente_id, string $producto_id, string $frecuencia_id, string $monto, string $cuotas, string $monto_cuotas, string $cargo, string $saldo)
  {
    $this->cliente_id = $cliente_id;
    $this->producto_id = $producto_id;
    $this->frecuencia_id = $frecuencia_id;
    $this->monto = $monto;
    $this->cuotas = $cuotas;
    $this->monto_cuotas = $monto_cuotas;
    $this->cargo = $cargo;
    $this->saldo = $saldo;

    $sqlInsert = "INSERT INTO cuentas(cliente_id, producto_id, frecuencia_id, monto, cuotas, monto_cuotas, cargo, saldo) VALUES (:cliente_id, :producto_id, :frecuencia_id, :monto, :cuotas, :monto_cuotas, :cargo, :saldo)";
    $valuesInsert = [
      'cliente_id' => $this->cliente_id,
      'producto_id' => $this->producto_id,
      'frecuencia_id' => $this->frecuencia_id,
      'monto' => $this->monto,
      'cuotas' => $this->cuotas,
      'monto_cuotas' => $this->monto_cuotas,
      'cargo' => $this->cargo,
      'saldo' => $this->saldo
    ];
    $resInsert = $this->insert($sqlInsert, $valuesInsert);
    return $resInsert;
  }

  // public function findById(string $id_cuenta)
  // {
  //   $sqlSelect = "SELECT * FROM cuentas WHERE id_cuenta = :id_cuenta AND status != 0";
  //   $valuesSelect = [
  //     'id_cuenta' => $id_cuenta
  //   ];
  //   $resSelect = $this->select($sqlSelect, $valuesInsert);
  //   return $resSelect;
  // }

  public function findById(string $id_cuenta)
  {
    $sqlSelect = "SELECT c.id_cuenta, c.frecuencia_id, f.frecuencia, c.monto, c.cuotas, c.monto, c.monto_cuotas, c.cargo, c.saldo, DATE_FORMAT(c.date_created, '%d-%m-%Y') as fecha_registro, c.cliente_id, cl.nombres, cl.apellidos, cl.telefono, cl.email, cl.direccion, cl.nit, cl.nombre_fiscal, cl.direccion_fiscal, c.producto_id, p.codigo AS cod_producto, p.nombre FROM cuentas AS c INNER JOIN frecuencias f ON c.frecuencia_id = f.id_frecuencia INNER JOIN clientes cl ON c.cliente_id = cl.id_cliente INNER JOIN productos p ON c.producto_id = p.id_producto WHERE id_cuenta = :id_cuenta AND c.status != 0";
    $valuesSelect = [
      'id_cuenta' => $id_cuenta
    ];
    $resSelect = $this->select($sqlSelect, $valuesSelect);
    d(!is_array($resSelect));
    return $resSelect;
  }
}
