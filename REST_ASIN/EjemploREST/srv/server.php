<?php
/*  Ejemplo Básico de servidor REST que implementa cuatro métodos HTTP
 * GET /clientes             -- Obtiene toda la lista de clientes
 * GET /clientes/1002        -- Obtiene un cliente con id = 1002
 * PUT /clientes/1004        -- Añade un nuevo cliente con id = 1004
 * DELETE /clientes/1005     -- Borrar un cliente con id = 1005
 * POST /clientes/1003       -- Incrementa las veces acceso (No es idempotente)
 * 
 * 
 * La respuesta es un  JSON o un código de error HTTP
 */


include_once('AccesoDatos.php');

class Server {
    
    private $db;
    
    private function paths($url) {
        // Obtiene todos lo valores de la URL
        // Solo se queda con el camino o ruta
        $uri = parse_url($url);
        return $uri['path'];
    }
    
    public function serve() {
        //echo " Procesando petición ";
        $this->db = AccesoDatos::initModelo();
        
        $uri =    $_SERVER['REQUEST_URI'];
        $metodo = $_SERVER['REQUEST_METHOD'];
        
        // URL  http://servidor/camino/server.php/clientes/1002
        // Separa la URL en cadenas que esten separadas con /
        $paths = explode('/', $this->paths($uri));
        $consulta=[];
        $anotar=false;
        // Salto todos la URL hasta encontrar clientes...
        foreach ( $paths as $value){
            if ($value == "clientes"){
                $anotar=true;
            }
            if ($anotar){
                $consulta[]=$value;
            }
        }
        
        $resource = array_shift($consulta);
        if ($resource == 'clientes') {
            $cod_cliente = array_shift($consulta);
            
            if (empty($cod_cliente)) {
                //URL clientes
                $this->procesar_base($metodo);
            } else {
                // URL cliente/1002
                $this->procesar_metodo($metodo, $cod_cliente);
            }
            
        } else {
            // We only handle resources under 'clients'
            header('HTTP/1.1 404 Not Found');
        }
    }
    
    private function procesar_base($metodo) {
        switch($metodo) {
            case 'GET':
                $this->get_clientes();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
                break;
        }
    }
    
    private function procesar_metodo($metodo, $cod_cliente) {
        switch($metodo) {
            case 'PUT':
                $this->put_cliente($cod_cliente);
                break;
                
            case 'DELETE':
                $this->borrar_cliente($cod_cliente);
                break;
                
            case 'GET':
                $this->get_uncliente($cod_cliente);
                break;
                
            case 'POST':
                $this->post_cliente($cod_cliente);
                break;
                
            default:
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET, PUT, DELETE, POST');
                break;
        }
    }
    // METODOS INVOCADOS
     // GET
     private function get_uncliente($cod_cliente) {
        if ($this->db->existeCliente($cod_cliente)) {
            echo json_encode($this->db->dameUnCliente($cod_cliente));
        } else {
            header('HTTP/1.1 404 Not Found');
        }
    }
    
    //GET
    private function get_clientes() {
        header('Content-type: application/json');
        $obj = $this->db->dameClientes();
        echo json_encode($obj);
    }
    
    // PUT
    private function put_cliente($cod){
        if ($this->db->existeCliente($cod)) {
            header('HTTP/1.1 409 Conflict');
            return;
        }
        /* PUT requests need to be handled
         * by reading from standard input.
         */
        $data = json_decode(file_get_contents('php://input'));
        if (is_null($data)) {
            header('HTTP/1.1 400 Bad Request');
            $this->get_clientes();
            return;
        }
        
        $nombre = $data->nombre;
        $clave  = $data->clave;
        $veces  = $data->veces;
        
        $this->db->nuevoCliente($cod,$nombre,$clave,$veces);
        $this->get_clientes();
    }
    
    // DELETE
    private function borrar_cliente($cod_cliente) {
        if ($this->db->existeCliente($cod_cliente)) {
            $this->db->borrarCliente($cod_cliente);
            $this->get_clientes();
        } else {
            header('HTTP/1.1 404 Not Found');
        }
    }
    
   
    // POST  
    private  function post_cliente($cod){
    
      if (! $this->db->existeCliente($cod)) {
        header('HTTP/1.1 404 Not Found');
        return;
        }
    /* PUT requests need to be handled
     * by reading from standard input.
     */
    $data = json_decode(file_get_contents('php://input'));
    if (is_null($data)) {
        header('HTTP/1.1 400 Bad Request');
        $this->get_clientes();
        return;
        }
    
    $valor = $data->valor;
    $this->db->incrementaVeces($cod,$valor);
    $this->get_clientes();
  }
} // End class

$server = new Server;
$server->serve();

?>