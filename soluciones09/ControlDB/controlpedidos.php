
<?php
include_once "AccesoDatos.php";
include_once "Cliente.php";
include_once "Pedido.php";

// Comprueba si los parámetros son correctos
if (empty($_GET["nombre"]) || empty($_GET["clave"])) {
    echo "Introduzca un valor de usuario y contraseña";
    header("Refresh:3; url=acceso.html");
    exit();
}
$ac = AccesoDatos::initModelo();
$nombre = $_GET["nombre"];
$clave  = $_GET["clave"];

$cli = $ac->ckequearUsuario($nombre, $clave);
if ($cli == null) {
    echo "ERROR: en el valor de usuario y contraseña <br>";
    ?>
    <button onclick="goBack()">Volver</button>
    <script>
    function goBack() {
        window.history.back();
    }
    </script> 
    <?php 
    //header("Refresh:3; url=acceso.html");
    exit();
}
// Incremento el número de veces que ha accedido
$ac->incrementarVeces($cli->cod_cliente);
// Obtengo los datos del modelo
$lista = $ac->obtenerListaPedidos($cli->cod_cliente);
$ac->close();
// Invoco a la vista
include_once('vistapedidos.php');
		

