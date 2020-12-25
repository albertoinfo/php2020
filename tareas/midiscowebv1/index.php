<?php

session_start();
include_once 'app/config.php';
include_once 'app/controlerFile.php';
include_once 'app/controlerUser.php';
include_once 'app/modeloUser.php';

// Inicializo el modelo
modeloUserInit();

// Enrutamiento
// Relación entre peticiones y función que la va a tratar
// Versión sin POO no manejo de Clases ni objetos
// Rutas en MODO  GESTIONUSUARIOS
$rutasUser = [
    "Inicio"      => "ctlUserInicio",
    "Alta"        => "ctlUserAlta",
    "Detalles"    => "ctlUserDetalles",
    "Modificar"   => "ctlUserModificar",
    "Borrar"      => "ctlUserBorrar",
    "Cerrar"      => "ctlUserCerrar",
    "VerUsuarios" => "ctlUserVerUsuarios",
    "Cancelar"    => "ctlUserDetalles"
];

// Rutas en MODO GESTIONFICHEROS
$rutasFicheros = [
    "VerFicheros" => "ctlFileVerFicheros",
    "Nuevo"       => "ctlFileNuevo",
    "Borrar"      => "ctlFileBorrar",
    "Renombrar"   => "ctlFileRenombrar",
    "Compartir"   => "ctlFileCompartir",
    "Cerrar"      => "ctlUserCerrar",
    "Descargar"   => "ctlFileDescargar"    
];

// Elimina posibles inyecciones HTML / PHP
limpiarArrayEntrada($_POST);
limpiarArrayEntrada($_GET);



// Si no hay usuario a Inicio
if (!isset($_SESSION['user'])){
    // Registro de usuario
    if (isset($_GET['orden']) && $_GET['orden']=="Registrarse"){
        $procRuta = "ctlUserRegistroUsuario";
    }
    else {
        $procRuta = "ctlUserInicio";
    }
} else {
    if ( $_SESSION['modo'] == GESTIONUSUARIOS){
        if (isset($_GET['orden'])){
            // La orden tiene una funcion asociada 
            if ( isset ($rutasUser[$_GET['orden']]) ){
                $procRuta =  $rutasUser[$_GET['orden']];
            }
            else {
                // Error no existe función para la ruta
                header('Status: 404 Not Found');
                echo '<html><body><h1>Error 404: No existe la ruta <i>' .
                    $_GET['ctl'] .
                    '</p></body></html>';
                    exit;
            }
        }
        else {
            $procRuta = "ctlUserVerUsuarios";
        }
    }
    if ($_SESSION['modo'] == GESTIONFICHEROS){
        if (isset($_GET['operacion'])){
            // La orden tiene una funcion asociada
            if ( isset ($rutasFicheros[$_GET['operacion']]) ){
                $procRuta =  $rutasFicheros[$_GET['operacion']];
            }
            else {
                // Error no existe función para la ruta
                header('Status: 404 Not Found');
                echo '<html><body><h1>Error 404: No existe la ruta <i>' .
                    $_GET['ctl'] .
                    '</p></body></html>';
                    exit;
            }
        }
        else {
            $procRuta = "ctlFileVerFicheros";
        }
    }
}
if (isset($_GET['msg'])){
    $msg = $_GET['msg'];
}
// Llamo a la función seleccionada
$procRuta();




