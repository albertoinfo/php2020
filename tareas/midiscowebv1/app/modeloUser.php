<?php 

include_once 'config.php';
include_once 'util.php';
/* DATOS DE USUARIO
• Identificador ( 5 a 10 caracteres, no debe existir previamente, solo letras y números)
• Contraseña ( 8 a 15 caracteres, debe ser segura)
• Nombre ( Nombre y apellidos del usuario
• Correo electrónico ( Valor válido de dirección correo, no debe existir previamente)
• Tipo de Plan (0-Básico |1-Profesional |2- Premium| 3- Máster)
• Estado: (A-Activo | B-Bloqueado |I-Inactivo )
*/
// Inicializo el modelo 
// Cargo los datos del fichero a la session
function modeloUserInit(){
    
    /*
    $tusuarios = [ 
         "admin"  => ["12345"      ,"Administrado"   ,"admin@system.com"   ,3,"A"],
         "user01" => ["user01clave","Fernando Pérez" ,"user01@gmailio.com" ,0,"A"],
         "user02" => ["user02clave","Carmen García"  ,"user02@gmailio.com" ,1,"B"],
         "yes33" =>  ["micasa23"   ,"Jesica Rico"    ,"yes33@gmailio.com"  ,2,"I"]
        ];
    */
    // Si ya esta rellena no lo recargo;
    if (!isset($_SESSION['tusuarios'])){
    $datosjson = @file_get_contents(FILEUSER) or die("ERROR al abrir fichero de usuarios");
    $tusuarios = json_decode($datosjson, true);
    $_SESSION['tusuarios'] = $tusuarios;
    }
      
}

// Comprueba usuario y contraseña son correctos (boolean)
function modeloOkUser($user,$clave){
    if ( isset($_SESSION['tusuarios'][$user]) ){
        return ($_SESSION['tusuarios'][$user][0] == $clave);
    }
    return false;
}


function modeloExisteID(String $user):bool{
    return isset($_SESSION['tusuarios'][$user]);
}

function modeloGetEmail(String $user){
    return $_SESSION['tusuarios'][$user][2];
}


/*
 * Chequea si hay error en el datos antes de guardarlos
 */
function modeloErrorValoresAlta ($user,$clave1, $clave2, $nombre, $email, $plan, $estado){
    if ( modeloExisteID($user))                         return USREXIST; 
    if ( preg_match("/^[a-zA-Z0-9]+$/", $user) == 0)      return USRERROR;
    if ( $clave1 != $clave2 )                           return PASSDIST;
    if ( !modeloEsClaveSegura($clave1) )                return PASSEASY;
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL))    return MAILERROR;
    if ( modeloExisteEmail($email))                     return MAILREPE;
    return false;
}

function modeloErrorValoresModificar($user, $clave1, $clave2, $nombre, $email, $plan, $estado){
    
    if ( $clave1 != $clave2 )                           return PASSDIST;
    if ( !modeloEsClaveSegura($clave1) )                return PASSEASY;
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL))    return MAILERROR;
    // SI se cambia el email
    $emailantiguo = modeloGetEmail($user);
    if ( $email != $emailantiguo && modeloExisteEmail($email))   return MAILREPE;
    return false;
}

/*
 * Comprueba que la contraseña es segura
 */

function modeloEsClaveSegura (String $clave):bool {
    if ( empty($clave))         return false;
    if (  strlen($clave) < 8 )  return false;
    if ( !hayMayusculas($clave) || !hayMinusculas($clave)) return false;
    if ( !hayDigito($clave))         return false;
    if ( !hayNoAlfanumerico($clave)) return false;

    return true;
}


/*
 * Comprueba si un correo existe
 */
function modeloExisteEmail( String $email):bool{
    foreach ($_SESSION['tusuarios'] as $clave => $datosusuario){
        if ($email == $datosusuario[2]) return true;
    }
    return false;
}




// Devuelve el plan de usuario (String)
function modeloObtenerTipo($user){
    $cod = $_SESSION['tusuarios'][$user][3];
    return PLANES[$cod];
}

// Borrar un usuario (boolean)
function modeloUserDel($userid){
    if (isset($_SESSION['tusuarios'][$userid])){
        unset($_SESSION['tusuarios'][$userid]);
        return true;
    } 
    return false;
}
// Añadir un nuevo usuario (boolean)
function modeloUserAdd($userid, $userdat){
   
    if (! isset($_SESSION['tusuarios'][$userid])){
        $_SESSION['tusuarios'][$userid]= $userdat;
        return true;
    }   
   return false; // Identificador repetido
}

// Actualizar un nuevo usuario (boolean)
function modeloUserUpdate ($userid, $userdat){
    
    if ( isset($_SESSION['tusuarios'][$userid])){
        $_SESSION['tusuarios'][$userid]= $userdat;
        return true;
    }
    return false; // Identificador no existe
}


// Tabla de todos los usuarios para visualizar
function modeloUserGetAll (){
    // Genero lo datos para la vista que no muestra la contraseña ni los códigos de estado o plan
    // sino su traducción a texto
    $tuservista=[];
    foreach ($_SESSION['tusuarios'] as $clave => $datosusuario){
        $tuservista[$clave] = [$datosusuario[1],
                               $datosusuario[2],
                               PLANES[$datosusuario[3]],
                               ESTADOS[$datosusuario[4]]
                               ];
    }
    return $tuservista;
}



// Datos de un usuario para visualizar
function modeloUserGet ($userid){
    if ( isset($_SESSION['tusuarios'][$userid])){
        return $_SESSION['tusuarios'][$userid];
    }
    return null;
}

// Vuelca los datos al fichero
function modeloUserSave(){
    
    $datosjon = json_encode($_SESSION['tusuarios']);
    file_put_contents(FILEUSER, $datosjon) or die ("Error al escribir en el fichero.");
}
