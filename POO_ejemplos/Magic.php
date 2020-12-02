<?php

class Magic
{
    private $atributo1;
    private $atributo2;
    private $varios= [];
    
    public function __construct(int $valor=0){
        $this->atributo1 = $valor;  
        $this->atributo2 = 0;
    }
    
    public function __set($nombre,$valor){
        // Compruebo un atributo concreto
        if ( $nombre == "atributo1"){
            $this->atributo1 = $valor;
        }
        // Puedo detectar si es uno atributo 
        // Ej atributo2
        $class = get_class($this);
        if ( property_exists($class, $nombre)){
            $this->$nombre = $valor; // Ojo $nombre
        } 
        
    }
    
    public function __get($nombre){
        // Compruebo un atributo concreto
        if ( $nombre == "atributo1"){
             return $this->atributo1;
        }
        // Puedo detectar si es uno atributo
        // Ej atributo2
        $class = get_class($this);
        if ( property_exists($class, $nombre)){
             return  $this->$nombre;
        }
        else{
            return "El valor no está definido";
        }
    }
    
    public function __toString() {
        $resu  ="<p>Objeto de tipo ".get_class($this)."<br>";
        $resu .="Atributo 1 = $this->atributo1 <br>";
        $resu .="Atributo 2 = $this->atributo2 <br>";
        $resu .="</p>";
        return $resu;
    }
    
    
    private function noimplementada (){
        echo " Error funcion no implementada. ";
    }
    
 
    
    public function incrementa (){
        $this->atributo1++;
        $this->atributo2++;
    }
    
    
    
    public function __call($metodo,$parametros){
            $this->noimplementada();
     }
            
}

