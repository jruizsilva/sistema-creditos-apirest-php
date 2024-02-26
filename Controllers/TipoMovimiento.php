<?php

class TipoMovimiento extends Controllers
{
  public function __construct()
  {
    parent::__construct();
  }
  public function findAll()
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == 'GET') {
        $tipo_movimientos = $this->getModel()->findAll();
        $resSuccess = [
          'success' => true,
          'message' => "Lista tipo movimientos",
          'data' => $tipo_movimientos
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

  public function save()
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['movimiento'])) {
          badRequestResponse("JSON Error: field movimiento es requerido");
        }
        if (empty($data['tipo_movimiento'])) {
          badRequestResponse("JSON Error: field tipo_movimiento es requerido");
        }
        $tipo_movimiento = $data['tipo_movimiento'];
        if ($tipo_movimiento != 1 && $tipo_movimiento != 2) {
          badRequestResponse("JSON Error: tipo_movimiento solo puede ser 1 o 2");
        }
        if (empty($data['descripcion'])) {
          badRequestResponse("JSON Error: field descripcion es requerido");
        }
        $movimiento = ucwords($data['movimiento']);
        $descripcion = strClean($data['descripcion']);
        $resTipoMovimiento = $this->getModel()->findByMovimiento($movimiento);

        if (!empty($resTipoMovimiento)) {
          badRequestResponse("El movimiento ya esta registrado");
        }
        $resInsert = $this->getModel()->save($movimiento, $tipo_movimiento, $descripcion);
        if ($resInsert > 0) {
          $resData = [
            'id_movimiento' => $resInsert,
            'movimiento' => $movimiento,
            'tipo_movimiento' => $tipo_movimiento,
            'descripcion' => $descripcion,
          ];
          $resSuccess = [
            'success' => true,
            'message' => "Tipo movimiento creado correctamente",
            'data' => $resData
          ];
          jsonResponse($resSuccess);
        } else {
          badRequestResponse("Error al crear el tipo movimiento");
        }
      } else {
        methodNotAllowedResponse($method);
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    die();
  }

}
