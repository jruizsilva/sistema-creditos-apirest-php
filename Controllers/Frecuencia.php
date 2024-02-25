<?php

class Frecuencia extends Controllers
{
  public function __construct()
  {
    parent::__construct();
  }


  public function findById(string $id_frecuencia)
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == 'GET') {
        if (empty($id_frecuencia)) {
          badRequestResponse("id_frecuencia es requerido");
        }
        if (!is_numeric($id_frecuencia)) {
          badRequestResponse("id_frecuencia debe ser un numero");
        }
        $frecuencia = $this->getModel()->findById($id_frecuencia);
        if (empty($frecuencia)) {
          notFoundResponse("Frecuencia no encontrada");
        }
        $resSuccess = [
          'success' => true,
          'message' => 'Frecuencia encontrada',
          'data' => $frecuencia
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
  public function findAll()
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == 'GET') {
        $frecuencias = $this->getModel()->findAll();
        $resSuccess = [
          'success' => true,
          'message' => 'Frecuencias encontradas',
          'data' => $frecuencias
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
  public function save()
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['frecuencia'])) {
          badRequestResponse("frecuencia es requerido");
        }
        $frecuencia = $data['frecuencia'];
        $resSave = $this->getModel()->save($frecuencia);
        if ($resSave > 0) {
          $resSuccess = [
            'success' => true,
            'message' => 'Frecuencia guardada',
            'data' => $data
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
  public function update(string $id_frecuencia)
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == 'PUT') {
        if (empty($id_frecuencia)) {
          badRequestResponse("id_frecuencia es requerido");
        }
        if (!is_numeric($id_frecuencia)) {
          badRequestResponse("id_frecuencia debe ser un numero");
        }
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['frecuencia'])) {
          badRequestResponse("frecuencia es requerido");
        }
        $frecuencia = $data['frecuencia'];
        $resFrecuencia = $this->getModel()->findById($id_frecuencia);
        if (empty($resFrecuencia)) {
          notFoundResponse("La frecuencia a actualizar no existe");
        }
        $resUpdate = $this->getModel()->updateFrecuencia($id_frecuencia, $frecuencia);
        if ($resUpdate > 0) {
          $resSuccess = [
            'success' => true,
            'message' => 'Frecuencia actualizada',
            'data' => $data
          ];
          jsonResponse($resSuccess, 200);
        }
      } else {
        methodNotAllowedResponse($method);
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    die();
  }

  public function deleteById(string $id_frecuencia)
  {
    try {
      $method = $_SERVER['REQUEST_METHOD'];
      if ($method == 'DELETE') {
        if (empty($id_frecuencia)) {
          badRequestResponse("id_frecuencia es requerido");
        }
        if (!is_numeric($id_frecuencia)) {
          badRequestResponse("id_frecuencia debe ser un numero");
        }
        $resFrecuencia = $this->getModel()->findById($id_frecuencia);
        if (empty($resFrecuencia)) {
          notFoundResponse("La frecuencia a eliminar no existe");
        }
        $resDelete = $this->getModel()->deleteFrecuencia($id_frecuencia);
        if ($resDelete > 0) {
          $resSuccess = [
            'success' => true,
            'message' => 'Frecuencia eliminada',
            'data' => $resFrecuencia
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
