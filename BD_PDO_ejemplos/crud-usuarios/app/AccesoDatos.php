<?php
include_once "Usuario.php";
include_once "config.php";

/*
 * Acceso a datos con BD Usuarios y Patrón Singleton
 */
class AccesoDatos {
    
    private static $modelo = null;
    private $dbh = null;
    private $stmt_usuarios = null;
    private $stmt_usuario  = null;
    private $stmt_boruser  = null;
    private $stmt_moduser   = null;
    private $stmt_creauser = null;
    
    public static function getModelo(){
        if (self::$modelo == null){
            self::$modelo = new AccesoDatos();
        }
        return self::$modelo;
    }
    
    // Creo un lista de alimentos, podría obtenerse de una base de datos
    private function __construct(){
        
        try {
            $dsn = "mysql:host=".SERVER_DB.";dbname=Usuarios;charset=utf8";
            $this->dbh = new PDO($dsn, "root", "root");
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexión ".$e->getMessage();
            exit();
        }
        // Construyo las consultas
        $this->stmt_usuarios = $this->dbh->prepare("select * from Usuarios");
        $this->stmt_usuario  = $this->dbh->prepare("select * form Usuarios where login=?");
        $this->stmt_boruser  = $this->dbh->prepare("delete form Usuarios where login =?");
        $this->stmt_moduser  = $this->dbh->prepare("update set nombre=:nombre, password=:password, comentario=:comentario where login=:login");
        $this->stmt_creauser = $this->dbh->prepare("insert into Usuarios Values(:login,:nombre,:password,:comentario");
        
    }
    
    // Devuelvo la lista de Usuarios
    public function getUsuarios ():array {
        $tuser = [];
        $this->stmt_usuarios->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
        
        if ( $this->stmt_usuarios->execute() ){
            while ( $user = $this->stmt_usuarios->fetch()){
               $tuser[]= $user;
            }
        }
        return $tuser;
    }
    
    // Devuelvo un usuario o null (false)
    public function getUsuario ($login):object {
        $user = null;
        
        $this->stmt_usuario->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
        $this->stmt_usuario->bindParam(':login', $login);
        if ( $this->stmt_usuario->execute() ){
             if ( $obj = $this->stmt_usuarios->fetch()){
                $user= $obj;
            }
        }
        return $user;
    }
    
    
    
     // Evito que se pueda clonar el objeto.
    public function __clone()
    { 
        trigger_error('La clonación no permitida', E_USER_ERROR); 
    }
}

