<?php
include_once 'Magic.php';

$objm = new Magic(10);
echo $objm;  

$objm->atributo1 = 10;
$objm->atributo2 = 23;
$objm->atributo23 = 10002; // No existe el atributo
echo "<br> ".$objm->atributo2;
echo "<br> ".$objm->atributo23; 

echo $objm;
$objm->incrementa();
$objm->decrementa(); // No existe el método
echo $objm;