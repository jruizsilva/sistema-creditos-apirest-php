<?php

class ClienteModel extends Mysql
{
  private int $idCliente;
  private string $identificacion;
  private string $nombres;
  private string $apellidos;
  private int $telefono;
  private string $email;
  private string $direccion;
  private string $nit;
  private string $nombreFiscal;
  private string $direccionFiscal;
  private int $status;
  public function __construct()
  {
    parent::__construct();
  }



  public function postCliente(string $identificacion, string $nombres, string $apellidos, int $telefono, string $email, string $direccion, string $nit, string $nombreFiscal, string $direccionFiscal): bool|int
  {
    $this->identificacion = $identificacion;
    $this->nombres = $nombres;
    $this->apellidos = $apellidos;
    $this->telefono = $telefono;
    $this->email = $email;
    $this->direccion = $direccion;
    $this->nit = $nit;
    $this->nombreFiscal = $nombreFiscal;
    $this->direccionFiscal = $direccionFiscal;

    $sql_select = "SELECT identificacion,email FROM clientes WHERE (email = :email OR identificacion = :identificacion) AND status = :status;";
    $selectValues = [
      ':email' => $this->email,
      ':identificacion' => $this->identificacion,
      ':status' => 1
    ];

    $resSelect = $this->select($sql_select, $selectValues);

    if (!empty($resSelect)) {
      return false;
    }
    $query_insert = "INSERT INTO clientes(identificacion,nombres,apellidos,telefono,email,direccion,nit,nombre_fiscal,direccion_fiscal) VALUES(:identificacion,:nombres,:apellidos,:telefono,:email,:direccion,:nit,:nombreFiscal,:direccionFiscal);";

    $postValues = [
      ':identificacion' => $this->identificacion,
      ':nombres' => $this->nombres,
      ':apellidos' => $this->apellidos,
      ':telefono' => $this->telefono,
      ':email' => $this->email,
      ':direccion' => $this->direccion,
      ':nit' => $this->nit,
      ':nombreFiscal' => $this->nombreFiscal,
      ':direccionFiscal' => $this->direccionFiscal
    ];
    $resInsert = $this->insert($query_insert, $postValues);
    return $resInsert;
  }

  public function putCliente(int $idCliente, string $identificacion, string $nombres, string $apellidos, int $telefono, string $email, string $direccion, string $nit, string $nombreFiscal, string $direccionFiscal): bool|string
  {
    $this->idCliente = $idCliente;
    $this->identificacion = $identificacion;
    $this->nombres = $nombres;
    $this->apellidos = $apellidos;
    $this->telefono = $telefono;
    $this->email = $email;
    $this->direccion = $direccion;
    $this->nit = $nit;
    $this->nombreFiscal = $nombreFiscal;
    $this->direccionFiscal = $direccionFiscal;

    $sql_select = "SELECT identificacion,email 
    FROM clientes
    WHERE
    (email = :email AND id_cliente != :id_cliente) 
    OR
    (identificacion = :identificacion AND id_cliente != :id_cliente)
    AND
    status = :status;";


    $select_values = [
      ':email' => $this->email,
      ':id_cliente' => $this->idCliente,
      ':identificacion' => $this->identificacion,
      ':status' => 1
    ];

    $resSelect = $this->select($sql_select, $select_values);

    if (!empty($resSelect)) {
      return false;
    }
    $sql = "UPDATE clientes SET identificacion = :identificacion, nombres = :nombres, apellidos = :apellidos, telefono = :telefono, email = :email, direccion = :direccion, nit = :nit, nombre_fiscal = :nombreFiscal, direccion_fiscal = :direccionFiscal WHERE id_cliente = :idCliente;";

    $put_values = [
      ':idCliente' => $this->idCliente,
      ':identificacion' => $this->identificacion,
      ':nombres' => $this->nombres,
      ':apellidos' => $this->apellidos,
      ':telefono' => $this->telefono,
      ':email' => $this->email,
      ':direccion' => $this->direccion,
      ':nit' => $this->nit,
      ':nombreFiscal' => $this->nombreFiscal,
      ':direccionFiscal' => $this->direccionFiscal
    ];

    $resUpdate = $this->update($sql, $put_values);
    return $resUpdate;
  }



  public function getClientes(): array|string
  {
    $sql = "SELECT id_cliente, identificacion, nombres, apellidos, telefono, email, direccion, nit, nombre_fiscal, direccion_fiscal, DATE_FORMAT(date_created, '%d-%m-%y') as fecha_registro FROM clientes WHERE status = 1 ORDER BY id_cliente DESC;";
    $resSelectAll = $this->select_all($sql);
    return $resSelectAll;
  }

  public function findById(int $idCliente): array|string
  {
    $sqlSelect = "SELECT id_cliente, identificacion, nombres, apellidos, telefono, email, direccion, nit, nombre_fiscal, direccion_fiscal, DATE_FORMAT(date_created, '%d-%m-%y') as fecha_registro FROM clientes WHERE id_cliente = :idCliente AND status != 0;";
    $selectValues = [
      ':idCliente' => $idCliente,
    ];
    return $this->select($sqlSelect, $selectValues);
  }

  public function deleteCliente(int $idCliente): bool|string
  {
    // $this->idCliente = $idCliente;
    // $sql = "DELETE FROM clientes WHERE `clientes`.`id_cliente` = :id_cliente;";
    // $delete_values = [
    //   ':id_cliente' => $this->idCliente
    // ];
    // $resDelete = $this->delete($sql, $delete_values);
    // return $resDelete;

    $this->idCliente = $idCliente;
    $sql = "UPDATE clientes SET status = 0 WHERE id_cliente = :idCliente;";
    $delete_values = [
      ':idCliente' => $this->idCliente
    ];
    $resDelete = $this->update($sql, $delete_values);
    return $resDelete;
  }
}
