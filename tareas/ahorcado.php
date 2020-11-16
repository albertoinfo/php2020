<html>
<head>
<meta charset="UTF-8">
<title>Ejercicio 2 Funciones</title>
</head>
<body>
<form>
 Introduzca una letra <input type="text" size="1"  maxlength="1" name="letra" autofocus>
</form>

<?php

define('MAXFALLOS', 6);

include_once 'funcionesahorcado.php';
session_start();

$ganadas = 0;
// Si existe el COOKIE obtengo las partidas ganadas
if ( isset($_COOKIE['ganadas'])){
    $ganadas = $_COOKIE['ganadas'];
}

// INICIO NO HAY PALABRA ELEGIDA (NUEVA PARTIDA)
if (! isset($_SESSION['palabrasecreta'])) {
    $_SESSION['palabrasecreta'] = elegirPalabra();
    $_SESSION['letrasusuario'] = "";
    $_SESSION['fallos'] = 0;
    echo " NUEVA PARTIDA <br>";
    
    if ( $ganadas > 0 ){
        echo " Has ganado $ganadas partidas.<br>";
    }
}


if (isset($_REQUEST['letra'])) {
    $letra =  $_REQUEST['letra'];
    if (comprobarLetra($letra, $_SESSION['palabrasecreta']) == false) {
        $_SESSION['fallos'] ++;
        if ($_SESSION['fallos'] >= MAXFALLOS) {
            echo " Superado el máximo número de fallos. Has perdido <br> ";
            session_destroy();
            echo "<a href=\"" . $_SERVER['PHP_SELF'] . "\"> Otra partida </a> </body></html>";
            exit();
        }
    } else {
        // Anoto la letra 
        $_SESSION['letrasusuario'] .= $letra;
    }
}

$palabramostrar = generaPalabraconHuecos($_SESSION['letrasusuario'], $_SESSION['palabrasecreta']);
echo " PALABRA :  $palabramostrar </br> ";
if ($palabramostrar == $_SESSION['palabrasecreta']) {
    $ganadas++;
    echo " Enhorabuena has ganado. Ya son $ganadas partidas ganadas.<br>";
    // Actualizo el cookie
    setcookie("ganadas",$ganadas, time()+ 2 * 7 * 24 * 3600);
    session_destroy();
    echo "<a href=\"" . $_SERVER['PHP_SELF'] . "\"> Otra partida </a> </body></html>";
    exit();
} else  {
    echo " Has comentido " . $_SESSION['fallos'] . " fallos <br>";
}

?>
</body>
</html>




