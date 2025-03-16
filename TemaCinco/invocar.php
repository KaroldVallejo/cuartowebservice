<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/econea/nusoap/src/nusoap.php';

$client = new nusoap_client('http://localhost/cuartowebservice/TemaCinco/servidor.php?wsdl', true);

//generar token cifrado
$token = hash('sha256', 'karold123');

//configurar encabezado con el token
$client->setHeaders('<token>' . $token . '</token>');

echo "<h3>Obtener Producto con ID 1</h3>";
$result = $client->call('obtenerProducto', ['id' => 1]);
echo '<pre>';
print_r($result);
echo '</pre>';

echo "<h3>Agregar Producto</h3>";
$result = $client->call('agregarProducto', ['nombre' => 'Tablet', 'precio' => 500.00, 'stock' => 20]);
echo '<pre>';
print_r($result);
echo '</pre>';

echo "<h3>Actualizar Producto</h3>";
$result = $client->call('actualizarProducto', ['id' => 1, 'nombre' => 'Laptop Pro', 'precio' => 1500.00, 'stock' => 8]);
echo '<pre>';
print_r($result);
echo '</pre>';

echo "<h3>Eliminar Producto</h3>";
$result = $client->call('eliminarProducto', ['id' => 3]);
echo '<pre>';
print_r($result);
echo '</pre>';

//mostrar errores
if ($client->fault) {
    echo '<h2>Fault</h2><pre>';
    print_r($result);
    echo '</pre>';
} else {
    $err = $client->getError();
    if ($err) {
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    }
}
?>