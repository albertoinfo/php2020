<?php
/*
 * CONSULTA A UN API
 * 
 */

// ESTA OPCIONES DE CONTEXTO SON NECESARIAS POR USAR EL PROXY  
$proxy = 'tcp://192.168.105.1:3128';

$context = array(
    'http' => array(
        'proxy' => $proxy,
        'request_fulluri' => True,
    ),
);
$context = stream_context_create($context);

// Sin proxy solo la URL
// Podermos usar directamente file_get_contents("http://www.iestetuan.es/";

// Con proxy
//$valor = file_get_contents("http://www.iestetuan.es/",false,$context);
//print_r($valor);


// $valor = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=Madrid,es&appid=f08a050596e0119a383c0335f18b11e5",false,$context);
// Devuelve un JSON
$valor = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=Madrid,es&appid=f08a050596e0119a383c0335f18b11e5");
$resu  =json_decode($valor);


// Ojo temperatura en grados kelvin 0º = 273
echo "Temperatura Máxima: ". ($resu->main->temp_max - 273). "<br>";
echo "Temperatura Mínima: ". ($resu->main->temp_min - 273). "<br>";

?>