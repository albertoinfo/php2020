<?php
session_start();

$cantidad = 0;
if ( isset($_SESSION['cantidad'])){
    $cantidad = $_SESSION['cantidad'];
}

if (!empty($_GET['oper'])){
    switch ($_GET['oper']) {
    case "suma"    :  $cantidad ++; break;
    case "resta"   :  $cantidad --; break;
    case "ver"     :  include_once 'respuesta.php'; break;
    case "verajax" :  
        header("Content-type: application/json; charset=utf-8");  
        $respuesta['cantidad'] = $cantidad;
        echo json_encode($respuesta);
    }
}
$_SESSION['cantidad'] = $cantidad;

?>
