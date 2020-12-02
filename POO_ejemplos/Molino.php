<?php

include_once 'MotorInterface.php';
/*
 * Molino hidraulico 
 */
class Molino implements MotorInterface
{
    private $cerrado;
    private $presion;
    private $aspas;
    
    function __construct(int $aspas){
        $this->aspas = $aspas;
        $this->cerrado = false;
    }
    
    public function encender():bool
    {
        if ($this->presion > 0){
        $this->cerrado = false;
        return true;
        }
        else{
            return false;
        }
    }

    public function apagar():bool
    {
        $this->cerrado = true;
        return true;
    }

    public function estaEncendido():bool
    {
        return ( $this->cerrado == false);
    }
}

