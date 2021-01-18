<?php 
class Cliente {
  private $cod_cliente;
  private $nombre;
  private $clave;
  private $veces;
  
  // Métodos mágicos para setter y getter
  
  public function __set($nombre,$valor){
      $class = get_class($this);
      if ( property_exists($class, $nombre)){
          $this->$nombre = $valor; // Ojo $nombre
      }       
  }
  
  public function __get($nombre){
      $class = get_class($this);
      if ( property_exists($class, $nombre)){
          return  $this->$nombre;
      }
   }
}
?>
