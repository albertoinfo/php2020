<?php
/* DATOS DE USUARIO
 • Identificador ( 5 a 10 caracteres, no debe existir previamente, solo letras y números)
 • Contraseña ( 8 a 15 caracteres, debe ser segura)
 • Nombre ( Nombre y apellidos del usuario
 • Correo electrónico ( Valor válido de dirección correo, no debe existir previamente)
 • Tipo de Plan (0-Básico |1-Profesional |2- Premium| 3- Máster)
 • Estado: (A-Activo | B-Bloqueado |I-Inactivo )
 */

class Usuario
{
   private $id;
   private $clave;
   private $nombre;
   private $email;
   private $plan;
   private $estado;
   
   
   // Getter con método mágico
   public function __get($atributo){
       $class = get_class($this);
       if(property_exists($class, $atributo)) {
           return $this->$atributo;
       }
   }
   
   // Set con método mágico
   public function __set($atributo,$valor){
       $class = get_class($this);
       if(property_exists($class, $atributo)) {
           $this->$atributo = $valor;
       }
   }
   
}

