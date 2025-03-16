<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/econea/nusoap/src/nusoap.php';

$client = new nusoap_client('http://localhost/cuartowebservice/TemaCinco/servidor.php?wsdl', true);

$error = $client->getError();
if ($error) {
    echo 'Error en la construcción del cliente: ' . $error;
    exit();
}

try {
    $response = $client->call('obtenerProducto', ['id' => 1]);
    echo 'Respuesta de obtenerProducto: ' . $response . '<br>';

    $response = $client->call('agregarProducto', ['nombre' => 'Producto Nuevo', 'precio' => 99.99, 'stock' => 10]);
    echo 'Respuesta de agregarProducto: ' . $response . '<br>';

    $response = $client->call('actualizarProducto', ['id' => 1, 'nombre' => 'Producto Actualizado', 'precio' => 79.99, 'stock' => 5]);
    echo 'Respuesta de actualizarProducto: ' . $response . '<br>';

    $response = $client->call('eliminarProducto', ['id' => 1]);
    echo 'Respuesta de eliminarProducto: ' . $response . '<br>';
} catch (Exception $e) {
    echo 'Excepción capturada: ' . $e->getMessage();
}
?>
