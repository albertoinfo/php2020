<?php

class Cifrador
{
    // Devuelve la clave cifrada
    public static function cifrar($clave) {
        return password_hash($clave, PASSWORD_DEFAULT, ['cost' => 10]);
    }
    // Comprueba que la clave normal y la cifrada son correctas
    public static function verificar($clave, $clavecifrada):bool {
        return password_verify($clave, $clavecifrada);
    }
}

