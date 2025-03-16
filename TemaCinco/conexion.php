<?php
class Conexion {
    private $pdo;

    public function __construct() {
        $host = 'localhost';
        $dbname = 'cincowebserv';
        $username = 'root';
        $password = "";

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }

    public function getPDO() {
        return $this->pdo;
    }

    public function cifrarToken($token) {
        return hash('sha256', $token);
    }
}
?>