<html>
<head>
<title>PHP: Listado de Directorios</title>
</head>
<body>
<?php
define('DIRECTORIO', '.'); // Define el directorio que se va a procesar

if (! is_dir(DIRECTORIO)) // Comprueba que realmente existe el directorio
    die("No existe el directorio " . DIRECTORIO);

// Abrimos el directorio
$dir_cursor = @opendir(DIRECTORIO) or die("Error al abrir el directorio");
// Mostramos cada entrada del directorio

echo "<table>";
echo "<tr><th>Nombre</th><th>Tamaño</th></tr>";
$entrada = readdir($dir_cursor); // lee primera entrada
while ($entrada !== false) // mientras haya datos
{
    if (is_file($entrada)) {
        $tamaño = filesize(DIRECTORIO . "/" . $entrada);
        echo "<tr><td> $entrada</td><td> : $tamaño </td></tr>";
    }
    $entrada = readdir($dir_cursor); // lee siguiente entrada
}
echo "</table>";

closedir($dir_cursor); // cerramos el directorio
?>
</body>
</html>