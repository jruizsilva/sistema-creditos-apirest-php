<?php

class Producto extends Controllers
{
  public function __construct()
  {
    parent::__construct();
  }


  public function producto($idProducto)
  {
    echo "Extraer un producto $idProducto";
  }
  public function productos()
  {
    echo "Extraer todos losproductos";
  }
  public function registro()
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method === 'POST') {
        $postData = json_decode(file_get_contents('php://input'), true);

        if (empty($postData['codigo'])) {
          badRequestResponse("El codigo es requerido");
        }
        if (empty($postData['nombre'])) {
          badRequestResponse("El nombre es requerido");
        }
        if (empty($postData['descripcion'])) {
          badRequestResponse("La descripcion es requerida");
        }
        if (empty($postData['precio']) || !is_numeric($postData['precio'])) {
          badRequestResponse("El precio es requerido");
        }

        $codigo = strClean($postData['codigo']);
        $nombre = ucwords(strClean($postData['nombre']));
        $descripcion = strClean($postData['descripcion']);
        $precio = $postData['precio'];

        $producto = $this->getModel()->findProductByCode($codigo);
        if (!empty($producto)) {
          badRequestResponse("El codigo ingresado ya esta registrado");
        }

        $resPost = $this->getModel()->postProducto($codigo, $nombre, $descripcion, $precio);
        if ($resPost > 0) {
          $datosProducto = [
            'id_producto' => $resPost,
            'codigo' => $codigo,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
          ];
          $resSuccess = [
            "status" => true,
            "msg" => "Producto registrado con exito",
            "data" => $datosProducto,
          ];
          jsonResponse($resSuccess, 201);
        } else {
          badRequestResponse("Error al registrar el producto");
        }
      } else {
        methodNotAllowedResponse($method);
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    die();
  }
  public function actualizar($idProducto)
  {
    echo "actualizar un producto: $idProducto";
  }
  public function eliminar($idProducto)
  {
    echo "eliminar un producto: $idProducto";
  }

}
