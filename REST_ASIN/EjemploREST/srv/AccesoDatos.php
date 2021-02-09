
<?php 
include_once 'Cliente.php';

//Implemento el modelo con  Patrón Singleton
class AccesoDatos {

	private static $modelo;
	private $dbh;
	

	public static function initModelo() {
		if (self::$modelo == null) {
			self::$modelo = new AccesoDatos();
		}
		return self::$modelo;
	}

	private function __construct(){
	    
	    try {
	        $dsn = "mysql:host=localhost;dbname=etienda;charset=utf8";
	        $this->dbh = new PDO($dsn, "root", "root");
	        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    } catch (PDOException $e){
	        echo "Error de conexión ".$e->getMessage();
	        exit();
	    }
	    
	}
	
	public function existeCliente($cod):bool{
	  $stmt = $this->dbh->prepare("SELECT cod_cliente FROM clientes where cod_cliente = ?");
	  $stmt->bindValue(1,$cod);
	  $stmt->execute();
	  return ($stmt->rowCount() > 0); 
	}
	
	
	public function borrarCliente($cod):bool{
	    $stmt = $this->dbh->prepare("Delete from clientes where cod_cliente = ?");
	    $stmt->bindValue(1,$cod);
	    $stmt->execute();
	    return ($stmt->rowCount() > 0); 
	   
	}
	
	public function dameUnCliente($cod):object {
	    $stmt = $this->dbh->prepare("select * from clientes where cod_cliente = ?");
	    $stmt->bindValue(1,$cod);
	    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
	    $stmt->execute();
	    $objcli = $stmt->fetch();
	    return $objcli;
	}
	
	public function nuevoCliente($cod_cliente,$nombre,$clave,$veces):bool {
	    $stmt = $this->dbh->prepare("insert into clientes (cod_cliente,nombre,clave,veces) values (?,?,?,?)");
	    $stmt->bindValue(1,$cod_cliente);
	    $stmt->bindValue(2,$nombre);
	    $stmt->bindValue(3,$clave);
	    $stmt->bindValue(4,$veces);
	    $stmt->execute();
	    return ($stmt->rowCount() > 0); 
	}
	
	
	
	public function dameClientes():array {
	    $stmt = $this->dbh->prepare("SELECT * FROM clientes ");
	    
	    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
	    $stmt->execute();
	    $listaresu = [];
	    while ( $objcli = $stmt->fetch()){
	        $listaresu []= $objcli;
	    }
	    return $listaresu;
    
	}
	
	public function incrementaVeces($cod,$valor):bool {
	    $stmt = $this->dbh->prepare("update clientes set veces = veces + ? where cod_cliente = ? ");
	    $stmt->bindValue(1,$valor);
	    $stmt->bindValue(2,$cod);
	    $stmt->execute();
	    return ($stmt->rowCount() > 0); 
	    
	}
		
	// Evito que se pueda clonar el objeto.
	
	public function clone() {
		
		die ("No se puede clonar la conexion a BD");
	}
}
