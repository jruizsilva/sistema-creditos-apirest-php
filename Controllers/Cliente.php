<?php

class Cliente extends Controllers
{
  public function __construct()
  {
    parent::__construct();
  }


  public function findById(string $idCliente)
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == "GET") {
        if (empty($idCliente)) {
          paramsErrorResponse("id es requerido");
        }
        if (!is_numeric($idCliente)) {
          paramsErrorResponse("$idCliente debe ser un numero");
        }
        $idCliente = intval($idCliente);
        $resSelect = $this->getModel()->findById($idCliente);
        if (is_array($resSelect) && empty($resSelect)) {
          notFoundResponse("Cliente con id $idCliente no encontrado");
        } else if (is_array($resSelect) && !empty($resSelect)) {
          $resSuccess = [
            'status' => 'success',
            "msg" => "Cliente encontrado",
            'data' => $resSelect
          ];
          jsonResponse($resSuccess);
        } else {
          internalServerErrorResponse("Error al obtener el cliente", $resSelect);
        }
      } else {
        methodNotAllowedResponse($method);
      }

    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  public function registro($params)
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == "POST") {
        $postData = json_decode(file_get_contents('php://input'), true);
        if (empty($postData['identificacion'])) {
          badRequestResponse("La identificacion es requerida");
        }
        if (empty($postData['nombres']) || !testString($postData['nombres'])) {
          badRequestResponse("Error en los nombres");
        }
        if (empty($postData['apellidos']) || !testString($postData['apellidos'])) {
          badRequestResponse("Error en los apellidos");
        }
        if (empty($postData['telefono']) || !testInt($postData['telefono'])) {
          badRequestResponse("Error en el telefono");
        }
        if (empty($postData['email']) || !testEmail($postData['email'])) {
          badRequestResponse("Error en el email");
        }
        if (empty($postData['direccion'])) {
          badRequestResponse("La direccion es requerida");
        }
        $identificacion = strval($postData['identificacion']);
        $nombres = ucwords(strtolower($postData['nombres']));
        $apellidos = ucwords(strtolower($postData['apellidos']));
        $telefono = intval($postData['telefono']);
        $email = strtolower($postData['email']);
        $direccion = strval($postData['direccion']);
        $nit = !empty($postData['nit']) ? strClean($postData['nit']) : "";
        $nombreFiscal = !empty($postData['nombre_fiscal']) ? strClean($postData['nombre_fiscal']) : "";
        $direccionFiscal = !empty($postData['direccion_fiscal']) ? strClean($postData['direccion_fiscal']) : "";

        $resInsert = $this->getModel()->postCliente($identificacion, $nombres, $apellidos, $telefono, $email, $direccion, $nit, $nombreFiscal, $direccionFiscal);
        if ($resInsert > 0) {
          $datosCliente = [
            'id_cliente' => $resInsert,
            'identificacion' => $identificacion,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'email' => $email,
            'direccion' => $direccion,
            'nit' => $nit,
            'nombre_fiscal' => $nombreFiscal,
            'direccion_fiscal' => $direccionFiscal,
          ];
          $resSuccess = [
            "status" => true,
            "msg" => "Datos guardatos correctamente",
            "data" => $datosCliente,
          ];
          jsonResponse($resSuccess, 201);
        } else {
          badRequestResponse("email o identificacion ya existe");
        }
      } else {
        methodNotAllowedResponse($method);
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    die();
  }

  public function clientes($params)
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == "GET") {
        $resGet = $this->getModel()->getClientes();
        jsonResponse($resGet);
      } else {
        methodNotAllowedResponse($method);
      }

    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  public function actualizar(int $idCliente)
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];

      if ($method === "PUT") {
        if (empty($idCliente)) {
          badRequestResponse("El id es requerido");
        }
        if (!is_numeric($idCliente)) {
          badRequestResponse("El id no es valido");
        }
        $updateData = json_decode(file_get_contents('php://input'), true);
        if (empty($updateData['identificacion'])) {
          badRequestResponse("La identificacion es requerida");
        }
        if (empty($updateData['nombres']) || !testString($updateData['nombres'])) {
          badRequestResponse("Error en los nombres");
        }
        if (empty($updateData['apellidos']) || !testString($updateData['apellidos'])) {
          badRequestResponse("Error en los apellidos");
        }
        if (empty($updateData['telefono']) || !testInt($updateData['telefono'])) {
          badRequestResponse("Error en el telefono");
        }
        if (empty($updateData['email']) || !testEmail($updateData['email'])) {
          badRequestResponse("Error en el email");
        }
        if (empty($updateData['direccion'])) {
          badRequestResponse("La direccion es requerida");
        }
        $identificacion = strval($updateData['identificacion']);
        $nombres = ucwords(strtolower($updateData['nombres']));
        $apellidos = ucwords(strtolower($updateData['apellidos']));
        $telefono = intval($updateData['telefono']);
        $email = strtolower($updateData['email']);
        $direccion = strval($updateData['direccion']);
        $nit = !empty($updateData['nit']) ? strClean($updateData['nit']) : "";
        $nombreFiscal = !empty($updateData['nombre_fiscal']) ? strClean($updateData['nombre_fiscal']) : "";
        $direccionFiscal = !empty($updateData['direccion_fiscal']) ? strClean($updateData['direccion_fiscal']) : "";

        $resCliente = $this->getModel()->getCliente($idCliente);
        if (empty($resCliente)) {
          notFoundResponse("El cliente no existe");
        }

        $resUpdate = $this->getModel()->putCliente($idCliente, $identificacion, $nombres, $apellidos, $telefono, $email, $direccion, $nit, $nombreFiscal, $direccionFiscal);

        if ($resUpdate === false) {
          badRequestResponse("El correo o la identificacion ya existe");
        }
        $datosCliente = [
          'id_cliente' => $idCliente,
          'identificacion' => $identificacion,
          'nombres' => $nombres,
          'apellidos' => $apellidos,
          'telefono' => $telefono,
          'email' => $email,
          'direccion' => $direccion,
          'nit' => $nit,
          'nombre_fiscal' => $nombreFiscal,
          'direccion_fiscal' => $direccionFiscal
        ];
        $resSuccess = [
          "status" => true,
          "msg" => "Datos actualizados correctamente",
          "data" => $datosCliente,
        ];
        jsonResponse($resSuccess, 200);
      } else {
        methodNotAllowedResponse($method);
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    die();

  }

  public function eliminar($idCliente)
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == "DELETE") {
        if (empty($idCliente)) {
          badRequestResponse("El id es requerido");
        }
        if (!is_numeric($idCliente)) {
          badRequestResponse("El id no es valido");
        }
        $resGet = $this->getModel()->getCliente($idCliente);
        if (empty($resGet)) {
          notFoundResponse("El cliente no existe");
        }
        $resDelete = $this->getModel()->deleteCliente($idCliente);
        if ($resDelete === false) {
          badRequestResponse("No se pudo eliminar el cliente");
        }
        $resSuccess = [
          "status" => true,
          "msg" => "Cliente eliminado correctamente",
        ];
        jsonResponse($resSuccess, 200);
      } else {
        methodNotAllowedResponse($method);
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    die();
  }
}
