<?php
include_once 'app/config.php';
include_once 'app/AccesoDatos.php';



// MOSTRA LOS DATOS DE LA TABLA DE ALMACENADA EN AL SESSION 
function mostrarDatos (){
    
    $titulos = [ "Nombre","login","Password","Comentario"];
    $msg = "<table>\n";
     // Identificador de la tabla
    $msg .= "<tr>";
    for ($j=0; $j < count($titulos); $j++){
        $msg .= "<th>$titulos[$j]</th>";
    }  
    $msg .= "</tr>";
    $auto = $_SERVER['PHP_SELF'];
    $db = AccesoDatos::getModelo();
    $tuser = $db->getUsuarios();
    foreach ($tuser as $user) {
        $msg .= "<tr>";
        $msg .= "<td>$user->nombre</td>";
        $msg .= "<td>$user->login</td>";
        $msg .= "<td>$user->password</td>";
        $msg .= "<td>$user->comentario</td>";
        $msg .="<td><a href=\"#\" onclick=\"confirmarBorrar('$user->nombre','$user->login');\" >Borrar</a></td>\n";
        $msg .="<td><a href=\"".$auto."?orden=Modificar&id=$user->login\">Modificar</a></td>\n";
        $msg .="<td><a href=\"".$auto."?orden=Detalles&id=$user->login\" >Detalles</a></td>\n";
        $msg .="</tr>\n";
        
    }
    $msg .= "</table>";
   
    return $msg;    
}

/*
 *  Funciones para limpiar la entreda de posibles inyecciones
 */

function limpiarEntrada(string $entrada):string{
    $salida = trim($entrada); // Elimina espacios antes y después de los datos
    $salida = stripslashes($salida); // Elimina backslashes \
    $salida = htmlspecialchars($salida); // Traduce caracteres especiales en entidades HTML
    return $salida;
}
// Función para limpiar todos elementos de un array
function limpiarArrayEntrada(array &$entrada){
 
    foreach ($entrada as $key => $value ) {
        $entrada[$key] = limpiarEntrada($value);
    }
}

