<code>
<?php 
print_r($_REQUEST);
echo "<hr>";
var_dump($_REQUEST);
echo "</code><hr><p></p>";

echo " Hola ".$_REQUEST["nombre"]."<br>";

if ( empty($_REQUEST['clave'])){
    echo " Conviene introducir una contraseña <br>";
}
$msg=<<<FIN
Estos son tu datos:
Modo de juego :$_REQUEST[modo]<br>
Nivel de juego : $_REQUEST[nivel]<br>
Su color es: <b> <span style='color:$_REQUEST[tucolor]'> COLOR </span></b> <br>
<hr>
FIN;

echo $msg;

$armas = $_REQUEST['armas'];
echo " Estas son sus armas elegidas: <ul>";
foreach ($armas as $valor){
    echo "<li>$valor</li>";
}
echo "</ul>";

if (isset($_REQUEST['velocidad']) ){
    echo " Su velocidad es ".$_REQUEST['velocidad']."<br>";
}


$poderes = $_REQUEST['poderes'];
echo " Has elegido ".count($poderes). " poderes :";
foreach ($poderes as $valor){
    echo "$valor,";
}

?>



</code>