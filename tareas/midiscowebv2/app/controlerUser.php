<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------

include_once 'config.php';
include_once 'modeloUserDB.php'; 
include_once 'util.php';


/*
 * Inicio Muestra o procesa el formulario (POST)
 */

function  ctlUserInicio(){
    $msg = "";
    $user ="";
    $clave ="";
    
    
    if ( $_SERVER['REQUEST_METHOD'] == "POST"){
        if (isset($_POST['user']) && isset($_POST['clave'])){
            $user =$_POST['user'];
            $clave=$_POST['clave'];
            // Compruebo el usuarios y su clave
            if ( modeloUserDB::OkUser($user,$clave)){
                $_SESSION['tipouser'] = modeloUserDB::ObtenerTipo($user);
                if ( $_SESSION['tipouser'] == "Máster"){
                    $_SESSION['modo'] = GESTIONUSUARIOS;
                    $_SESSION['user'] = $user;
                    header('Location:index.php?orden=VerUsuarios');
                }
                else {
                    // Si el usuario está activo
                    if ( modeloUserDB::estaActivo($user)){
                    $_SESSION['user'] = $user;
                    $_SESSION['modo'] = GESTIONFICHEROS;     
                    header('Location:index.php?operacion=VerFicheros');
                    } else {
                        $msg= TMENSAJES['USERNOACTIVO'];
                    }
                }
            }
            else {
                $msg=TMENSAJES['LOGINERROR'];
           }  
        }
    }
    
    include_once 'plantilla/formAcceso.php';
}

/*
 *  Muestra y procesa el formulario de alta (ADMINISTRADOR)
 */
function ctlUserAlta (){
    $user="";
    $nombre="";
    $clave1="";
    $clave2="";
    $email="";
    $plan="";
    $estado="";
    
    // Si hay que procesar el formulario
    if ( $_SERVER['REQUEST_METHOD'] == "POST"){
        
        if (empty($_POST['user'])  || empty($_POST['nombre']) ||
            empty($_POST['clave1'])|| empty($_POST['clave2']) || 
            empty($_POST['email']) || !isset($_POST['plan'])   ||  !isset($_POST['estado']) ){
        $msg = TMENSAJES['NOVACIO'];    
        } else {
           
        $user =   $_POST['user'];
        $nombre = $_POST['nombre'];
        $clave1 = $_POST['clave1'];
        $clave2 = $_POST['clave2'];
        $email  = $_POST['email'];
        $plan   = $_POST['plan'];
        $estado = $_POST['estado'];
        $msg = modeloUserDB::errorValoresAlta($user, $clave1, $clave2, $nombre, $email, $plan, $estado);
        if ( !$msg ){
            // OJO EL NOMBRE DE $user
            if ( modeloUserDB::UserAdd($user, [$clave1,$nombre,$email,$plan,$estado]) 
                &&   mkdir("./app/dat/".$user) ){
            $msg= TMENSAJES['USERSAVE'];  
            header('Location:index.php?orden=VerUsuarios&msg='.urlencode($msg));
            }
            else {
            $msg= TMENSAJES['USERNOSAVE'];"Error: No se puede añadir el usuario";
            }
       }   
     }
    }
    include_once 'plantilla/fnuevo.php';
}
/*
 *  Muestra y procesa el formulario de Modificación (ADMINISTRADOR)
 */
function ctlUserModificar (){
    
    if ( $_SERVER['REQUEST_METHOD'] == "GET"){
        $datosuser = modeloUserDB::UserGet($_GET['userid']);
        $user=$_GET['userid'];
        $clave1=$datosuser[0];
        $clave2=$datosuser[0];
        $nombre=$datosuser[1];
        $email =$datosuser[2];
        $plan  =$datosuser[3];
        $estado =$datosuser[4];
        $_SESSION['claveold'] = $clave1;  // Detectar si la contraseña  se cambia
    }
    // Si hay que procesar el formulario
    if ( $_SERVER['REQUEST_METHOD'] == "POST"){
        
        if (empty($_POST['user'])  || empty($_POST['nombre']) ||
            empty($_POST['clave1'])|| empty($_POST['clave2']) ||
            empty($_POST['email']) || !isset($_POST['plan'])   ||  !isset($_POST['estado']) ){
                $msg = TMENSAJES['NOVACIO'];
        } else {
            
            $user =   $_POST['user'];
            $nombre = $_POST['nombre'];
            $clave1 = $_POST['clave1'];
            $clave2 = $_POST['clave2'];
            $email  = $_POST['email'];
            $plan   = $_POST['plan'];
            $estado = $_POST['estado'];

            // ERROR al fallo correo electronico, seguridad contraseña, etc
            $msg = modeloUserDB::errorValoresModificar($user, $clave1, $clave2, $nombre, $email, $plan, $estado);
            if ( !$msg ){
                $cambiarcontraseña = ( $_SESSION['claveold'] != $clave1); 
                if ( modeloUserDB::UserUpdate($user, [$clave1,$nombre,$email,$plan,$estado], $cambiarcontraseña) ){
                $msg=TMENSAJES['USERUPDATE']." $user";
                header('Location:index.php?orden=VerUsuarios&msg='.urlencode($msg));
            }
            else {
                $msg= TMENSAJES['ERRORUPDATE']." $user ";
            }
          }
        }
    }
    include_once 'plantilla/fmodifica.php';
}



function ctlUserRegistroUsuario(){
    $user="";
    $nombre="";
    $clave1="";
    $clave2="";
    $email="";
    $plan="";
    $estado="I"; // Estado Inactivo
    
    // Si hay que procesar el formulario
    if ( $_SERVER['REQUEST_METHOD'] == "POST"){
        //var_dump($_POST);
        
        if (empty($_POST['user'])  || empty($_POST['nombre']) ||
            empty($_POST['clave1'])|| empty($_POST['clave2']) ||
            empty($_POST['email']) || !isset($_POST['plan'])  ){
                $msg = TMENSAJES[NOVACIO];;
        } else {
            
            $user =   $_POST['user'];
            $nombre = $_POST['nombre'];
            $clave1 = $_POST['clave1'];
            $clave2 = $_POST['clave2'];
            $email  = $_POST['email'];
            $plan   = $_POST['plan'];
  
            $msg = modeloUserDB::errorValoresAlta($user, $clave1, $clave2, $nombre, $email, $plan, $estado);
            if ( !$msg ){
                if ( modeloUserDB::UserAdd($user, [$clave1,$nombre,$email,$plan,$estado])
                    && mkdir("./app/dat/".$user)){
                    $msg= TMENSAJES['USERREG'];
                    header('Location:index.php?orden=Inicio&msg='.urlencode($msg));
                }
                else {
                    $msg= TMENSAJES['ERRORADDUSER'];
                }
            }
        }
    }
    include_once 'plantilla/fregistro.php';
}




function ctlUserDetalles(){
    $datosuser = modeloUserDB::UserGet($_GET['userid']);
    $userid=$_GET['userid'];
    $nombre=$datosuser[1];
    $email =$datosuser[2];
    $plancod   =$datosuser[3];
    $estadocod =$datosuser[4];
    //$nficheros = modeloFileNficheros($userid);
    //$nbytes    = modeloFileNbytes($userid);
    //Datos de prueba 
    $plan  =PLANES[$plancod];
    $estado=ESTADOS[$estadocod];
    $nficheros = 25;
    $nbytes =5000;
    
    //Máster no tiene límite
    if ( $plan != "Máster" ){
    $pficheros = 100.0*$nficheros/  LIMITE_FICHEROS[$plancod];
    $pespacio  = 100.0*$nbytes   /  LIMITE_ESPACIO [$plancod];
    } else {
        $pficheros = "0";
        $pespacio  = "0";
    }
    $nbytes = number_format($nbytes, 0, ',', '.');
    // Mostrar códigos traducidos
    
    
    include_once 'plantilla/detalle.php';
    
}
/*
 * Borrar usuarios
 */

function ctlUserBorrar(){
    $userid=$_GET['userid'];
    // Chequear error si no existe GET
    if ( modeloUserDB::UserDel($userid) && eliminarDir("./app/dat/".$userid )){
        $msg= TMENSAJES['USERDEL'];
    }
    else {
        $msg= TMENSAJES['ERRORDEL'];
    }
    header('Location:index.php?orden=VerUsuarios&msg='.urlencode($msg));
}

/*
 * Cierra la sesión y vuelca los datos
 */
function ctlUserCerrar(){
    session_destroy();
    modeloUserDB::closeDB();
    header('Location:index.php');
}

/*
 * Muestro la tabla con los usuario 
 */ 
function ctlUserVerUsuarios (){
    // Obtengo los datos del modelo
    $usuarios = modeloUserDB::GetAll(); 
    // Invoco la vista 
    include_once 'plantilla/verusuarios.php';
   
}