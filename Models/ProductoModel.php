<?php

class ProductoModel extends Mysql
{
  private int $id_producto;
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
    $sqlSelect = "SELECT * FROM productos WHERE codigo = :codigo";
    $valuesSelect = [':codigo' => $codigo];

    $producto = $this->select($sqlSelect, $valuesSelect);

    return $producto;
  }
}
