<?php
include_once 'app/config.php';

//Carga los datos de un fichoro de texto
function cargarDatostxt(){
    // Si no existe lo creo
    $tabla=[]; 
    if (!is_readable(FILEUSER) ){
        // El directorio donde se crea tiene que tener permisos adecuados
        $fich = @fopen(FILEUSER,"w") or die ("Error al crear el fichero.");
        fclose($fich);
    }
    $fich = @fopen(FILEUSER, 'r') or die("ERROR al abrir fichero de usuarios"); // abrimos el fichero para lectura
    
    while ($linea = fgets($fich)) {
        $partes = explode('|', trim($linea));
        // Escribimos la correspondiente fila en tabla
        $tabla[]= [ $partes[0],$partes[1],$partes[2],$partes[3]];
        }
    fclose($fich);
    return $tabla;
}

function mostrarDatos (){
    echo "<table>\n";
     // Identificador de la tabla
    // Generamos la cabecera de la tabla
    echo "<tr><th>usuario</th><th>login</th><th>pasword</th></tr>\n";
    $auto = $_SERVER['PHP_SELF'];
    $id=0;
    $nusuarios = count($_SESSION['tuser']);
    for($id=0; $id< $nusuarios ; $id++){
        echo "<tr>";
        $datosusuario = $_SESSION['tuser'][$id];
        for ($j=0; $j < CAMPOSVISIBLES; $j++){
            echo "<td>$datosusuario[$j]</td>";
        }
        echo "<td><a href=\"#\" onclick=\"confirmarBorrar('$datosusuario[0]',$id);\" >Borrar</a></td>\n";
        echo "<td><a href=\"".$auto."?orden=Modificar&id=$id\">Modificar</a></td>\n";
        echo "<td><a href=\"".$auto."?orden=Detalles&id=$id\" >Detalles</a></td>\n";
        echo "</tr>\n";
        
    }
    echo "</table>";
}