<?php
require_once "vendor/econea/nusoap/src/nusoap.php";

$urlWSDL = "http://localhost/cuartowebservice/servidor.php?wsdl";
$cliente = new nusoap_client($urlWSDL, true);

// Verificar si hay errores en la conexión
$error = $cliente->getError();
if ($error) {
    die("Error en la conexión con el servicio SOAP: <pre>$error</pre>");
}

// Definir las operaciones a probar
$operaciones = [
    "sumar" => [10, 5],
    "restar" => [10, 5],
    "multiplicar" => [10, 5],
    "dividir" => [10, 5],
    "dividir_cero" => [10, 0]  // Prueba especial para división por cero
];

echo '<link rel="stylesheet" type="text/css" href="styles.css">';
echo '<div class="container">';
echo "<h2>Resultados de las operaciones</h2>";

foreach ($operaciones as $operacion => $valores) {
    echo "<h3>" . ucfirst($operacion) . "</h3>";
    
    $resultado = $cliente->call("$operacion", [
        "num1" => $valores[0],
        "num2" => $valores[1]
    ]);    

    if ($cliente->fault) {
        echo "<div class='result'><pre>Falla en el servicio: " . print_r($resultado, true) . "</pre></div>";
    } else {
        $error = $cliente->getError();
        if ($error) {
            echo "<div class='result'><pre>Error en la solicitud: $error</pre></div>";
        } else {
            echo "<div class='result'><pre>Respuesta: " . print_r($resultado, true) . "</pre></div>";
        }
    }
}
echo '</div>';
?>