<?php
require_once "vendor/econea/nusoap/src/nusoap.php";

class ClienteSOAP {
    private $client;
    private $urlWSDL = "http://localhost/cuartowebservice/servidor.php?wsdl";

    public function __construct() {
        $this->client = new nusoap_client($this->urlWSDL, true);
        $error = $this->client->getError();
        if ($error) {
            throw new Exception("Error en el constructor: " . $error);
        }
    }

    public function llamarOperacion($operacion, $num1, $num2) {
        $resultado = $this->client->call("$operacion", array("num1" => $num1, "num2" => $num2));
        
        if ($this->client->fault) {
            return array("fault" => "Error", "detalle" => $resultado);
        } else {
            $error = $this->client->getError();
            if ($error) {
                return array("error" => "Error", "detalle" => $error);
            } else {
                return array("resultado" => $resultado);
            }
        }
    }
}

try {
    $clienteSOAP = new ClienteSOAP();
    
    echo '<link rel="stylesheet" type="text/css" href="styles.css">';
    echo '<div class="container">';
    echo "<h2>Resultados:</h2>";

    $operaciones = ["sumar", "restar", "multiplicar", "dividir"];
    foreach ($operaciones as $operacion) {
        echo "<h3>$operacion</h3>";
        $respuesta = $clienteSOAP->llamarOperacion($operacion, 10, 5);
        echo "<div class='result'><pre>" . print_r($respuesta, true) . "</pre></div>";
    }

    echo "<h3>Prueba de división por 0</h3>";
    $respuesta = $clienteSOAP->llamarOperacion("dividir", 10, 0);
    echo "<div class='result'><pre>" . print_r($respuesta, true) . "</pre></div>";

    echo '</div>';
} catch (Exception $e) {
    echo "<h2>Excepción</h2><div class='result'><pre>" . $e->getMessage() . "</pre></div>";
}
?>