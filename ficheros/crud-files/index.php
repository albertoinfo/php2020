<?php
session_start();
include_once 'app/funciones.php';

// Tabla de usuarios
if (!isset ($_SESSION['tuser'])){
    $_SESSION['tuser'] = cargarDatostxt();
    
}


if ($_SERVER['REQUEST_METHOD'] == "GET" ){
    
    if ( isset($_GET['orden'])){
        switch ($_GET['orden']) {
            case "Nuevo"    : accionAlta(); break;
            case "Borrar"   : accionBorrar($_GET['id']); break;
            case "Modificar": accionModificar($_GET['id']); break;
            case "Detalles" : accionDetalles($_GET['id']); break;
            case "Terminar" : accionTerminar(); break;
        }
    }
    else {
    include_once "app/principal.php";
    }   
}
