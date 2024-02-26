<?php

class Cuenta extends Controllers
{
  public function __construct()
  {
    parent::__construct();
  }

  public function findAll()
  {

  }

  public function create()
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['cliente_id'])) {
          badRequestResponse("JSON error: cliente_id es requerido");
        }
        if (!is_numeric($data['cliente_id'])) {
          badRequestResponse("JSON error: cliente_id debe ser un numero");
        }
        if (empty($data['producto_id'])) {
          badRequestResponse("JSON error: producto_id es requerido");
        }
        if (!is_numeric($data['producto_id'])) {
          badRequestResponse("JSON error: producto_id debe ser un numero");
        }
        if (empty($data['frecuencia_id'])) {
          badRequestResponse("JSON error: frecuencia_id es requerido");
        }
        if (!is_numeric($data['frecuencia_id'])) {
          badRequestResponse("JSON error: frecuencia_id debe ser un numero");
        }
        if (empty($data['monto'])) {
          badRequestResponse("JSON error: monto es requerido");
        }
        if (!is_numeric($data['monto'])) {
          badRequestResponse("JSON error: monto debe ser un numero");
        }
        if (empty($data['cuotas'])) {
          badRequestResponse("JSON error: cuotas es requerido");
        }
        if (!is_numeric($data['cuotas'])) {
          badRequestResponse("JSON error: cuotas debe ser un numero");
        }
        if (empty($data['monto_cuotas'])) {
          badRequestResponse("JSON error: monto_cuotas es requerido");
        }
        if (!is_numeric($data['monto_cuotas'])) {
          badRequestResponse("JSON error: monto_cuotas debe ser un numero");
        }
        if (empty($data['cargo'])) {
          badRequestResponse("JSON error: cargo es requerido");
        }
        if (!is_numeric($data['cargo'])) {
          badRequestResponse("JSON error: cargo debe ser un numero");
        }
        if (empty($data['saldo'])) {
          badRequestResponse("JSON error: saldo es requerido");
        }
        if (!is_numeric($data['saldo'])) {
          badRequestResponse("JSON error: saldo debe ser un numero");
        }

        $cliente_id = strClean($data['cliente_id']);
        $producto_id = strClean($data['producto_id']);
        $frecuencia_id = strClean($data['frecuencia_id']);
        $monto = strClean($data['monto']);
        $cuotas = strClean($data['cuotas']);
        $monto_cuotas = strClean($data['monto_cuotas']);
        $cargo = strClean($data['cargo']);
        $saldo = strClean($data['saldo']);

        $resInsert = $this->getModel()->create($cliente_id, $producto_id, $frecuencia_id, $monto, $cuotas, $monto_cuotas, $cargo, $saldo);

        if (is_numeric($resInsert) && $resInsert > 0) {
          $resData = [
            'id_cuenta' => $resInsert
          ];
          $resSuccess = [
            'success' => true,
            'message' => 'Cuenta creada con exito',
            'data' => $resData
          ];
          jsonResponse($resSuccess);
        } else {
          internalServerErrorResponse("Error al crear la cuenta", $resInsert);
        }

      } else {
        methodNotAllowedResponse($method);
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    die();
  }

  public function update()
  {

  }

  public function findById(string $id_cuenta)
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == 'GET') {
        if (empty($id_cuenta)) {
          badRequestResponse("JSON error: id_cuenta es requerido");
        }
        if (!is_numeric($id_cuenta)) {
          badRequestResponse("JSON error: id_cuenta debe ser un numero");
        }
        $resSelect = $this->getModel()->findById($id_cuenta);
        if (is_array($resSelect) && !empty($resSelect)) {
          $resSuccess = [
            'success' => true,
            'message' => 'Cuenta encontrada con exito',
            'data' => $resSelect
          ];
          jsonResponse($resSuccess);
        } else if (is_array($resSelect) && empty($resSelect)) {
          notFoundResponse("Cuenta no encontrada");
        } else {
          internalServerErrorResponse("Error al obtener datos", $resSelect);
        }
      } else {
        methodNotAllowedResponse($method);
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    die();
  }

  public function deleteById(string $id_cuenta)
  {

  }
}
