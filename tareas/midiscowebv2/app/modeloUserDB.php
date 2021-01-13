<?php

include_once 'config.php';
include_once 'util.php';
include_once 'Cifrador.php';
include_once 'Usuario.php';

class ModeloUserDB {

     private static $dbh = null; 
     private static $consulta_user = "Select * from Usuarios where id = ?";
     private static $consulta_email= "Select email from Usuarios where id = ?";
     private static $delete_user   = "Delete from Usuarios where id = ?"; 
     private static $insert_user   = "Insert into Usuarios (id,clave,nombre,email,plan,estado)".
                                      "VALUES (:id,:clave,:nombre,:email,:plan,:estado)";
     private static $update_user   =  "UPDATE Usuarios set  clave=?, nombre =?, ".
                                      "email=?, plan=?, estado=? where id =?";
     
     
public static function init(){
   
    if (self::$dbh == null){
        try {
            // Cambiar  los valores de las constantes en config.php
            $dsn = "mysql:host=".DBSERVER.";dbname=".DBNAME.";charset=utf8";
            self::$dbh = new PDO($dsn,DBUSER,DBPASSWORD);
            // Si se produce un error se genera una excepción;
            self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexión ".$e->getMessage();
            exit();
        }
        
    }
    
}



// Comprueba usuario y contraseña son correctos (boolean)
public static function OkUser($user,$clave){
    
    $stmt = self::$dbh->prepare(self::$consulta_user);
    $stmt->bindValue(1,$user);
    $stmt->execute();  
    if ($stmt->rowCount() > 0 ){
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $fila = $stmt->fetch();
        $clavecifrada = $fila['clave'];
        if ( Cifrador::verificar($clave, $clavecifrada)){
            return true;
        }
    } 
    return false;
}

// Comprueba si ya existe un usuario con ese identificar
public static function existeID(String $user):bool{
    
    $stmt = self::$dbh->prepare(self::$consulta_user);
    $stmt->bindValue(1,$user);
    $stmt->execute();  
    if ($stmt->rowCount() > 0 ){
       return true;     
    }
    return false;
}

//Comprueba si existe el email en la BD
public static function existeEmail(String $email){
    $stmt = self::$dbh->prepare(self::$consulta_email);
    $stmt->bindValue(1,$email);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        return true;
    }
    return false;
}

public  static function getEmail(String $userid){
    $stmt = self::$dbh->prepare(self::$consulta_user);
    $stmt->bindValue(1,$userid);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $fila = $stmt->fetch();
        return $fila['email'];
    }
    return  TMENSAJES['ERRORSELECT']; 
}


// Devuelve el plan de usuario (String)
public static function ObtenerTipo($user):string{
    
    $stmt = self::$dbh->prepare(self::$consulta_user);
    $stmt->bindValue(1,$user);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $fila = $stmt->fetch();
        $plancod = $fila['plan'];
        return PLANES[$plancod];
    }
    return  TMENSAJES['ERRORSELECT']; 
}

public static function estaActivo (String $user):bool {
    $stmt = self::$dbh->prepare(self::$consulta_user);
    $stmt->bindValue(1,$user);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        $fila = $stmt->fetch();
        if ( $fila['estado'] == "A"){
            return true;
        }
    }
    return false;
}


/*
 * Chequea si hay error en el datos antes de guardarlos
 */
public static function errorValoresAlta ($user,$clave1, $clave2, $nombre, $email, $plan, $estado){
    if ( self::existeID($user))                         return TMENSAJES['USREXIST'];
    if ( preg_match("/^[a-zA-Z0-9]+$/", $user) == 0)    return TMENSAJES['USRERROR'];
    if ( $clave1 != $clave2 )                           return TMENSAJES['PASSDIST'];
    if ( ! self:: EsClaveSegura($clave1) )              return TMENSAJES['PASSEASY'];
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL))    return TMENSAJES['MAILERROR'];
    if ( self::existeEmail($email))                     return TMENSAJES['MAILREPE'];
    return false;
}

public static function errorValoresModificar($user, $clave1, $clave2, $nombre, $email, $plan, $estado){
    
    if ( $clave1 != $clave2 )                           return TMENSAJES['PASSDIST'];
    if ( !self:: EsClaveSegura($clave1) )               return TMENSAJES['PASSEASY'];
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL))    return TMENSAJES['MAILERROR'];
    // SI se cambia el email
    $emailantiguo = self::getEmail($user);
    if ( $email != $emailantiguo && self::ExisteEmail($email))   return TMENSAJES['MAILREPE'];
    return false;
}

/*
 * Comprueba que la contraseña es segura
 */

public static function EsClaveSegura (String $clave):bool {
    if ( empty($clave))         return false;
    if (  strlen($clave) < 8 )  return false;
    if ( !hayMayusculas($clave) || !hayMinusculas($clave)) return false;
    if ( !hayDigito($clave))         return false;
    if ( !hayNoAlfanumerico($clave)) return false;
    
    return true;
}


// Borrar un usuario (boolean)
public static function UserDel($userid){
    $stmt = self::$dbh->prepare(self::$delete_user);
    $stmt->bindValue(1,$userid);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        return true;
    }
    return false;
}
// Añadir un nuevo usuario (boolean)
public static function UserAdd($userid, $userdat):bool{
    $user = new Usuario();
    $user->id = $userid;
    // Guardo la clave cifrada
    $user->clave  = Cifrador::cifrar($userdat[0]); 
    $user->nombre = $userdat[1];
    $user->email  = $userdat[2];
    $user->plan   = $userdat[3];
    $user->estado = $userdat[4];
    $stmt = self::$dbh->prepare(self::$insert_user);
    $stmt->bindValue(":id",$user->id);
    $stmt->bindValue(":clave",$user->clave);
    $stmt->bindValue(":nombre",$user->nombre);
    $stmt->bindValue(":email",$user->email);
    $stmt->bindValue(":plan",$user->plan);
    $stmt->bindValue(":estado",$user->estado);
    
    if ($stmt->execute ()){
       return true;
    }
    return false; 
}

// Actualizar un nuevo usuario (boolean)
// PENDIENTE GUARDAR LA CLAVE CIFRADA  SI SEA MODIFICADO 
public static function UserUpdate ($userid, $userdat,$cambiarclave = false){
    $stmt = self::$dbh->prepare(self::$update_user);
    if ( $cambiarclave ){
        $userdat[0]=Cifrador::cifrar($userdat[0]);
    }
    $stmt->bindValue(1,$userdat[0] );
    $stmt->bindValue(2,$userdat[1] );
    $stmt->bindValue(3,$userdat[2] );
    $stmt->bindValue(4,$userdat[3] );
    $stmt->bindValue(5,$userdat[4] );
    $stmt->bindValue(6,$userid);
    if ($stmt->execute ()){
        return true;
    }
    
    return false; 
}


// Tabla de todos los usuarios para visualizar
public static function GetAll ():array{
    // Genero los datos para la vista que no muestra la contraseña ni los códigos de estado o plan
    // sino su traducción a texto  PLANES[$fila['plan']],
    $stmt = self::$dbh->query("select * from Usuarios");
    
    $tUserVista = [];
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while ( $fila = $stmt->fetch()){
        $datosuser = [ 
            $fila['nombre'],
            $fila['email'], 
            PLANES[$fila['plan']],
            ESTADOS[$fila['estado']]
           ];
        $tUserVista[$fila['id']] = $datosuser;       
    }
    return $tUserVista;
}



// Datos de un usuario para visualizar
public static function UserGet ($userid){
    $datosuser = [];
    $stmt = self::$dbh->prepare(self::$consulta_user);
    $stmt->bindValue(1,$userid);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        // Obtengo un objeto de tipo Usuario
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
        $uobj = $stmt->fetch();
        $datosuser = [ 
                     $uobj->clave,
                     $uobj->nombre,
                     $uobj->email,
                     $uobj->plan,
                     $uobj->estado
                     ];
        return $datosuser;
    }
    return null;    
    
}

public static function closeDB(){
    self::$dbh = null;
}

} // class
