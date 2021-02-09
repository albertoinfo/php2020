
<?php 
include_once 'Cliente.php';
include_once 'Pedido.php';
    

//Implemento el modelo con  Patrón Singleton
/**
 * @author alberto
 *
 */
class AccesoDatos {

	private static $modelo;
	private $dbh;
	private $stmt1;
	private $stmt2;
	private $stmt3;
	
    /**
     *  Crea o devuelve la instancia ya creada
     *  Patrón Singleton
     * @return object AccesoDatos
     * 
     */
	public static function initModelo() {
		if (self::$modelo == null) {
			self::$modelo = new AccesoDatos();
		}
		return self::$modelo;
	}

	/**
	 * Constructor privado invocados desde initModelo
	 * Crea la conexión y las sentencias preparadas
	 */
	
	private function __construct(){
	    
	    try {
	        $dsn = "mysql:host=localhost;dbname=etienda;charset=utf8";
	        $this->dbh = new PDO($dsn, "root", "root");
	        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    } catch (PDOException $e){
	        echo "Error de conexión ".$e->getMessage();
	        exit();
	    }
	    // Construyo las consultas
	    $this->stmt1 = $this->dbh->prepare("select * from clientes where nombre = ? and clave = ?");
	    $this->stmt2 = $this->dbh->prepare("select * from pedidos where cod_cliente = ?");
	    $this->stmt3 = $this->dbh->prepare("update clientes SET veces=veces+1 where cod_cliente= ?");

	    
	}
	
	/** 
	 *  Comprueba si el usuario y su clave existen
	 * 
	 *  @param string $usuario - nombre del usuario
	 *  @param string $clave - contraseña del usuario
     *  @return object de tipo cliente o null
	 * 
	 */

	public  function ckequearUsuario(String $usuario, String $clave) {

		$objcli = null;
		$this->stmt1->bindValue(1, $usuario);
		$this->stmt1->bindValue(2, $clave);
		$this->stmt1->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
	    $this->stmt1->execute();
	    if ( $objcli = $this->stmt1->fetch()){
				return $objcli;
		}
		return null;
	}

	/**
	 *  Devuelve la lista de pedidos de un usuario a partir
	 *  de su código
	 *
	 *  @param int $cod_cliente - Código de cliente
	 *  @return Array de pedidos o array vacio
	 *
	 */
	// Devuelvo la lista de Pedidos
	public function obtenerListaPedidos(int $cod_cliente):array {
		$listaresu=[];
		$this->stmt2->bindValue(1, $cod_cliente);
		$this->stmt2->setFetchMode(PDO::FETCH_CLASS, 'Pedido');
		$this->stmt2->execute();
		while ( $objcli = $this->stmt2->fetch()){
		   $listaresu []= $objcli;   
		}
		return $listaresu;
	}

	/**
	 *  Incremente el número de acceso de usuario
	 *  @param String $nobmre del cliente
	 */
	public function incrementarVeces(int $codigo) {
	    $this->stmt3->bindValue(1, $codigo);
	    $this->stmt3->execute();
	}

	
	/**
	 * Evito que se pueda clonar el objeto.
	 * Termina la aplicación.
	 */
	
	public function clone() {
		
		die ("No se puede clonar la conexion a BD");
	}
	
	public function close(){
	    $this->dbh = null;
	}
}
