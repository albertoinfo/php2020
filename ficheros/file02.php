<?php 
/*
 *  Añade datos recogidos por un formulario en un fichero 
 *  con formato: nombre | contraseña
 */
?>
<html>
<head>
<title>PHP: Añadir datos a Ficheros</title>
</head>
<body>
<?php

define("FICH_DATOS", 'usuarios.txt');

// Muestro el contenido del fichero, si no existe lo crea vacio
 if (!is_readable(FICH_DATOS) ){
     // El directorio donde se crea tiene que tener permisos adecuados
      $fich = @fopen(FICH_DATOS,"w") or die ("Error al crear el fichero.");
      fclose($fich);
 }
 $fich = @fopen(FICH_DATOS, 'r') or die("ERROR al abrir fichero de usuarios"); // abrimos el fichero para lectura
 echo "<table border='1'>\n";
 echo "<tr><th>Usuario</th><th>Contraseña</th</tr>\n";
 while ($linea = fgets($fich)) {
        $partes = explode('|', trim($linea));
        // "Limpiamos" la línea y la troceamos obtiendo sus componentes
        echo "<tr><td>$partes[0]</td><td>$partes[1]</td>"; // Escribimos la correspondiente fila de la tabla
 }
 fclose($fich);
 echo "</table><br>\n";

?>
<h2> Introduzca más datos en el fichero:</h2>
<form  action="<?= $_SERVER['PHP_SELF']?>" method="POST">
Usuario:       <input type='text'     name='user' size='10' > &nbsp;
Contraseña   : <input type='password' name='clave' size='10' ><br>
<input type='submit' value='Enviar' >
</form>

<?php 
// Añado datos al fichero 
if ( $_SERVER['REQUEST_METHOD'] == 'POST') 
{
    // abrimos el fichero para añadir al final
    $fich = @fopen(FICH_DATOS, 'a') or die("ERROR al abrir fichero"); 
    $cadena = $_POST['user'] . '|' . $_POST['clave'] . "\n";
    // Creamos cadena a grabar -con su separador-
    $ok = fwrite($fich, $cadena); // escribimos datos en el fichero
    echo ($ok) ? "Datos añadidos al fichero" : "Error al añadir datos";
    fclose($fich);
    header("Refresh:0");
}
?>
</body>
</html>
