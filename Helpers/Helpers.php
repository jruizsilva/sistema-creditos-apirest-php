<?php
function base_url(): string
{
  return BASE_URL;
}

function media(): string
{
  return BASE_URL . 'Assets';
}

function d($data)
{
  echo "<pre>";
  print_r($data);
  echo "</pre>";
}

function strClean($strCadena): string
{
  $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
  $string = trim($string); //Elimina espacios en blanco al inicio y al final
  $string = stripslashes($string); // Elimina las \ invertidas
  $string = str_ireplace("<script>", "", $string);
  $string = str_ireplace("</script>", "", $string);
  $string = str_ireplace("<script src>", "", $string);
  $string = str_ireplace("<script type=>", "", $string);
  $string = str_ireplace("SELECT * FROM", "", $string);
  $string = str_ireplace("DELETE FROM", "", $string);
  $string = str_ireplace("INSERT INTO", "", $string);
  $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
  $string = str_ireplace("DROP TABLE", "", $string);
  $string = str_ireplace("OR '1'='1", "", $string);
  $string = str_ireplace('OR "1"="1"', "", $string);
  $string = str_ireplace('OR ´1´=´1´', "", $string);
  $string = str_ireplace("is NULL; --", "", $string);
  $string = str_ireplace("is NULL; --", "", $string);
  $string = str_ireplace("LIKE '", "", $string);
  $string = str_ireplace('LIKE "', "", $string);
  $string = str_ireplace("LIKE ´", "", $string);
  $string = str_ireplace("OR 'a'='a", "", $string);
  $string = str_ireplace('OR "a"="a', "", $string);
  $string = str_ireplace("OR ´a´=´a", "", $string);
  $string = str_ireplace("OR ´a´=´a", "", $string);
  $string = str_ireplace("--", "", $string);
  $string = str_ireplace("^", "", $string);
  $string = str_ireplace("[", "", $string);
  $string = str_ireplace("]", "", $string);
  $string = str_ireplace("==", "", $string);
  return $string;
}

function jsonResponse(array $data, int $code = 200)
{
  if (is_array($data)) {
    header("HTTP/1.1 " . $code);
    header("Content-Type: application/json");
    echo json_encode($data, true);
  }
  die();
}

function badRequestResponse(string $message)
{
  $data = [
    "status" => false,
    "message" => $message
  ];
  jsonResponse($data, 400);
}

function internalServerErrorResponse(string $message, string $error)
{
  $data = [
    "status" => false,
    "message" => $message,
    "error" => $error
  ];
  jsonResponse($data, 500);
}

function methodNotAllowedResponse(string $method)
{
  $data = [
    "status" => false,
    "message" => "Error en la solicitud $method"
  ];
  jsonResponse($data, 405);
}

function notFoundResponse($message = null)
{
  $data = [
    "status" => false,
    "message" => $message ?? "Recurso no encontrado"
  ];
  jsonResponse($data, 404);
}

function testString(string $data)
{
  $re = '/[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/m';

  if (preg_match($re, $data) === 1) {
    return true;
  } else {
    return false;
  }
}

function testInt($data)
{
  $re = '/[0-9]+$/m';

  if (preg_match($re, $data) === 1) {
    return true;
  } else {
    return false;
  }
}

function testEmail(string $email)
{
  $re = '/^(([^<>()\[\]\\\\.,;:\s@”]+(\.[^<>()\[\]\\\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/m';

  if (preg_match($re, $email) === 1) {
    return true;
  } else {
    return false;
  }
}

