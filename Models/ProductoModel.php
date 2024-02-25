<?php

class ProductoModel extends Mysql
{
  private string $id_producto;
  private string $codigo;
  private string $nombre;
  private string $descripcion;
  private float $precio;
  private int $status;

  public function __construct()
  {
    parent::__construct();
  }

  public function postProducto(string $codigo, string $nombre, string $descripcion, float $precio): bool|int
  {
    $this->codigo = $codigo;
    $this->nombre = $nombre;
    $this->descripcion = $descripcion;
    $this->precio = $precio;

    $sqlPost = "INSERT INTO productos (codigo, nombre, descripcion, precio) VALUES (:codigo, :nombre, :descripcion, :precio)";
    $valuesPost = [
      ':codigo' => $this->codigo,
      ':nombre' => $this->nombre,
      ':descripcion' => $this->descripcion,
      ':precio' => $this->precio
    ];

    $resPost = $this->insert($sqlPost, $valuesPost);
    return $resPost;
  }

  public function findProductByCode(string $codigo)
  {
    $sqlSelect = "SELECT * FROM productos WHERE codigo = :codigo AND status = 1";
    $valuesSelect = [':codigo' => $codigo];

    $producto = $this->select($sqlSelect, $valuesSelect);

    return $producto;
  }

  public function findProductById(string $id_producto)
  {
    $sqlSelect = "SELECT id_producto, codigo, nombre, descripcion, precio, DATE_FORMAT(date_created, '%d-%m-%Y') as fechaRegistro FROM productos WHERE id_producto = :id_producto AND status = 1";
    $valuesSelect = [':id_producto' => $id_producto];

    $producto = $this->select($sqlSelect, $valuesSelect);

    return $producto;
  }

  public function updateProducto(string $id_producto, string $codigo, string $nombre, string $descripcion, float $precio): bool|int
  {
    $this->id_producto = $id_producto;
    $this->codigo = $codigo;
    $this->nombre = $nombre;
    $this->descripcion = $descripcion;
    $this->precio = $precio;

    $sqlSelect = "SELECT * FROM productos WHERE codigo = :codigo AND id_producto != :id_producto";
    $valuesSelect = [
      ':codigo' => $this->codigo,
      ':id_producto' => $this->id_producto
    ];
    $producto = $this->select($sqlSelect, $valuesSelect);
    if (!empty($producto)) {
      return false; // El código del producto ya existe en la base de datos.
    }


    $sqlUpdate = "UPDATE productos SET codigo = :codigo, nombre = :nombre, descripcion = :descripcion, precio = :precio WHERE id_producto = :id_producto";
    $valuesUpdate = [
      ':id_producto' => $this->id_producto,
      ':codigo' => $this->codigo,
      ':nombre' => $this->nombre,
      ':descripcion' => $this->descripcion,
      ':precio' => $this->precio
    ];

    $resUpdate = $this->update($sqlUpdate, $valuesUpdate);
    return $resUpdate;
  }

  public function findAllProductos()
  {
    $sqlSelectAll = "SELECT id_producto, codigo, nombre, descripcion, precio, DATE_FORMAT(date_created, '%d-%m-%Y') as fechaRegistro FROM productos WHERE status = 1 ORDER BY id_product DESC";
    $productos = $this->select_all($sqlSelectAll);
    return $productos;
  }

  public function deleteProducto(string $id_producto): bool|int
  {
    $this->id_producto = $id_producto;

    $sqlDelete = "UPDATE productos SET status = 0 WHERE id_producto = :id_producto";
    $valuesDelete = [':id_producto' => $this->id_producto];

    $resDelete = $this->update($sqlDelete, $valuesDelete);
    return $resDelete;
  }
}
