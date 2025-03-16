<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/econea/nusoap/src/nusoap.php';
require_once 'conexion.php';

$server = new soap_server();
$server->configureWSDL('ProductoService', 'urn:ProductoService');

$server->register('obtenerProducto', ['id' => 'xsd:int'], ['return' => 'xsd:string'], 'urn:ProductoService', 'urn:ProductoService#obtenerProducto', 'rpc', 'encoded', 'Obtiene un producto por su ID');
$server->register('agregarProducto', ['nombre' => 'xsd:string', 'precio' => 'xsd:float', 'stock' => 'xsd:int'], ['return' => 'xsd:string'], 'urn:ProductoService', 'urn:ProductoService#agregarProducto', 'rpc', 'encoded', 'Agrega un nuevo producto');
$server->register('actualizarProducto', ['id' => 'xsd:int', 'nombre' => 'xsd:string', 'precio' => 'xsd:float', 'stock' => 'xsd:int'], ['return' => 'xsd:string'], 'urn:ProductoService', 'urn:ProductoService#actualizarProducto', 'rpc', 'encoded', 'Actualiza un producto existente');
$server->register('eliminarProducto', ['id' => 'xsd:int'], ['return' => 'xsd:string'], 'urn:ProductoService', 'urn:ProductoService#eliminarProducto', 'rpc', 'encoded', 'Elimina un producto por su ID');

function obtenerProducto($id) {
    $conexion = new Conexion();
    $pdo = $conexion->getPDO();

    $stmt = $pdo->prepare('SELECT * FROM productos WHERE id = ?');
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    return $producto ? json_encode($producto) : 'Producto no encontrado';
}

function agregarProducto($nombre, $precio, $stock) {
    $conexion = new Conexion();
    $pdo = $conexion->getPDO();

    $stmt = $pdo->prepare('INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)');
    $resultado = $stmt->execute([$nombre, $precio, $stock]);

    return $resultado ? 'Producto agregado exitosamente' : 'Error al agregar el producto';
}

function actualizarProducto($id, $nombre, $precio, $stock) {
    $conexion = new Conexion();
    $pdo = $conexion->getPDO();

    $stmt = $pdo->prepare('UPDATE productos SET nombre = ?, precio = ?, stock = ? WHERE id = ?');
    $resultado = $stmt->execute([$nombre, $precio, $stock, $id]);

    return $resultado ? 'Producto actualizado exitosamente' : 'Error al actualizar el producto';
}

function eliminarProducto($id) {
    $conexion = new Conexion();
    $pdo = $conexion->getPDO();

    $stmt = $pdo->prepare('DELETE FROM productos WHERE id = ?');
    $resultado = $stmt->execute([$id]);

    return $resultado ? 'Producto eliminado exitosamente' : 'Error al eliminar el producto';
}

// Procesa solicitudes
$server->service(file_get_contents("php://input"));
?>