<?php
require_once "vendor/econea/nusoap/src/nusoap.php";

$namespace = "http://localhost/cuartowebservice";

// Crear un nuevo servidor SOAP
$server = new nusoap_server();
$server->configureWSDL("OperacionesWebService", $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

// Definir funciones del servicio (antes estaban en `servicio.php`)
function sumar($num1, $num2) {
    if (!is_numeric($num1) || !is_numeric($num2)) {
        return "Error: Los parámetros deben ser numéricos.";
    }
    return "El resultado de la suma es: " . ($num1 + $num2);
}

function restar($num1, $num2) {
    if (!is_numeric($num1) || !is_numeric($num2)) {
        return "Error: Los parámetros deben ser numéricos.";
    }
    return "El resultado de la resta es: " . ($num1 - $num2);
}

function multiplicar($num1, $num2) {
    if (!is_numeric($num1) || !is_numeric($num2)) {
        return "Error: Los parámetros deben ser numéricos.";
    }
    return "El resultado de la multiplicación es: " . ($num1 * $num2);
}

function dividir($num1, $num2) {
    if (!is_numeric($num1) || !is_numeric($num2)) {
        return "Error: Los parámetros deben ser numéricos.";
    }
    if ($num2 == 0) {
        return "Error: No se puede dividir entre cero.";
    }
    return "El resultado de la división es: " . ($num1 / $num2);
}

// Registrar funciones correctamente
$server->register(
    "sumar",
    array("num1" => "xsd:integer", "num2" => "xsd:integer"),
    array("return" => "xsd:string"),
    $namespace,
    false,
    "rpc",
    "encoded",
    "Suma dos números enteros"
);

$server->register(
    "restar",
    array("num1" => "xsd:integer", "num2" => "xsd:integer"),
    array("return" => "xsd:string"),
    $namespace,
    false,
    "rpc",
    "encoded",
    "Resta dos números enteros"
);

$server->register(
    "multiplicar",
    array("num1" => "xsd:integer", "num2" => "xsd:integer"),
    array("return" => "xsd:string"),
    $namespace,
    false,
    "rpc",
    "encoded",
    "Multiplica dos números enteros"
);

$server->register(
    "dividir",
    array("num1" => "xsd:integer", "num2" => "xsd:integer"),
    array("return" => "xsd:string"),
    $namespace,
    false,
    "rpc",
    "encoded",
    "Divide dos números enteros (validando división entre 0)"
);

// Procesar la solicitud SOAP
$server->service(file_get_contents("php://input"));
exit;
?>