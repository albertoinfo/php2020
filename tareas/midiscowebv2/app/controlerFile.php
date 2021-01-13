<?php
// --------------------------------------------------------------
// Controlador que realiza la gestión de ficheros de un usuario
// ---------------------------------------------------------------
include_once 'config.php';

function ctlFileVerFicheros(){
    $arrayficheros = [];
    $nfiles=0;
    $tamañototal = 0;
    $directorio = RUTA_FICHEROS."/".$_SESSION['user'];
    if (is_dir($directorio)){
        if ($dh = opendir($directorio)){
            while (($fichero = readdir($dh)) !== false){
                $rutayfichero = $directorio.'/'.$fichero;
                if ( is_file($rutayfichero)){
                    $arrayficheros[$nfiles]['nombre'] = $fichero;
                    $arrayficheros[$nfiles]['tipo']   = mime_content_type($rutayfichero);
                    $tamaño = filesize($rutayfichero);
                    $arrayficheros[$nfiles]['tamaño'] = $tamaño;
                    $arrayficheros[$nfiles]['fecha']  =  date("d/m/Y",filectime ($rutayfichero));
                    $nfiles++;
                    $tamañototal += $tamaño;
                    
                }
            }
            closedir($dh);
        }
       
    }
    include_once 'plantilla/vertablaficheros.php';
}


function ctlFileNuevo(){
    
}
function ctlFileBorrar(){
    
}
function ctlFileRenombrar(){
    
}
function ctlFileCompartir(){
    $fichero = $_GET['nombre'];
    $usuario = $_GET['user'];
    
}
function ctlFileDescargar(){
    
}
