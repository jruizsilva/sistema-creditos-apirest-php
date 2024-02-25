<?php

class Producto extends Controllers
{
  public function __construct()
  {
    parent::__construct();
  }


  public function producto(string $idProducto)
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method === 'GET') {
        if (empty($idProducto)) {
          badRequestResponse("El id es requerido");
        }
        if (!is_numeric($idProducto)) {
          badRequestResponse("El id no es valido");
        }
        $producto = $this->getModel()->findProductById($idProducto);
        if (empty($producto)) {
          notFoundResponse("Producto no encontrado");
        }
        $resSuccess = [
          "status" => true,
          "msg" => "Producto encontrado con exito",
          "data" => $producto,
        ];
        jsonResponse($resSuccess);
      } else {
        methodNotAllowedResponse($method);
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    die();
  }
  public function productos()
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method === 'GET') {
        $productos = $this->getModel()->findAllProductos();
        $resSuccess = [
          "status" => true,
          "msg" => "Productos encontrados con exito",
          "data" => $productos,
        ];
        jsonResponse($resSuccess);
      } else {
        badRequestResponse("Metodo no permitido");
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
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
  public function actualizar(string $idProducto)
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == "PUT") {
        if (empty($idProducto)) {
          badRequestResponse("El id es requerido");
        }
        if (!is_numeric($idProducto)) {
          badRequestResponse("El id no es valido");
        }
        $updateData = json_decode(file_get_contents('php://input'), true);
        if (empty($updateData['codigo'])) {
          badRequestResponse("El codigo es requerido");
        }
        if (empty($updateData['nombre'])) {
          badRequestResponse("El nombre es requerido");
        }
        if (empty($updateData['descripcion'])) {
          badRequestResponse("La descripcion es requerida");
        }
        if (empty($updateData['precio']) || !is_numeric($updateData['precio'])) {
          badRequestResponse("El precio es requerido");
        }
        $codigo = strClean($updateData['codigo']);
        $nombre = ucwords(strClean($updateData['nombre']));
        $descripcion = strClean($updateData['descripcion']);
        $precio = $updateData['precio'];

        $producto = $this->getModel()->findProductById($idProducto);
        if (empty($producto)) {
          badRequestResponse("No existe el producto a actualizar");
        }
        $resUpdate = $this->getModel()->updateProducto($idProducto, $codigo, $nombre, $descripcion, $precio);

        if ($resUpdate === false) {
          badRequestResponse("El código del producto ya esta registrado");
        }
        if ($resUpdate === true) {
          $datosProducto = [
            'id_producto' => intval($idProducto),
            'codigo' => $codigo,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
          ];
          $resSuccess = [
            "status" => true,
            "msg" => "Producto actualizado con exito",
            "data" => $datosProducto,
          ];
          jsonResponse($resSuccess, 200);
        }

      } else {
        methodNotAllowedResponse($method);
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }
  public function eliminar(string $idProducto)
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == "DELETE") {
        if (empty($idProducto)) {
          badRequestResponse("El id es requerido");
        }
        if (!is_numeric($idProducto)) {
          badRequestResponse("El id no es valido");
        }
        $producto = $this->getModel()->findProductById($idProducto);
        if (empty($producto)) {
          notFoundResponse("No existe el producto a eliminar");
        }
        $resDelete = $this->getModel()->deleteProducto($idProducto);
        if ($resDelete === true) {
          $resSuccess = [
            "status" => true,
            "msg" => "Producto eliminado con exito",
          ];
          jsonResponse($resSuccess, 200);
        }
      } else {
        methodNotAllowedResponse($method);
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

}
