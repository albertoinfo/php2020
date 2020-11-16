<html>
<head>
<meta charset="UTF-8">
<title>Minicasino</title>
</head>
<body>

<?php
session_start();

$visitas = 1;
if ( isset( $_COOKIE['visitascasino'])){
    $visitas = $_COOKIE['visitascasino'];
}


if (! isset($_SESSION['disponible'])) {
    if ( empty($_POST['cantidadini'])) {
        include "form_bienvenida.php";
        exit();
    } else {
        // Me ha indicado la cantidad
        $_SESSION['disponible'] = $_POST['cantidadini'];
         header("Refresh:0");
    }
}

// Si realiza una apuesta
if (isset($_POST["apostar"])) {
    $msg = procesarApuesta($_POST["cantidad"],$_SESSION['disponible'],$_POST['apuesta']);
    echo $msg;
    }

 // Si abandona o ya no le queda dinero
if (isset($_POST["dejar"]) || ($_SESSION["disponible"] == 0) ) {
   dejarCasino($visitas);
   exit();
} 
// Muestro el formulario
include "form_apuesta.php";
?>
</body>
</html>

<?php

/**
 *  FUNCIONES AUXILIARES
 */

function procesarApuesta(int $valorapuesta, int & $saldodisponible, string $apuesta): String {
    $msgresultado = "";
    if ($valorapuesta > $saldodisponible ) {
        $msgresultado .= "Error: no dispone de  $valorapuesta euros disponibles. <br> ";
    } else {
        $resultado = (random_int(1, 100) % 2 == 0) ? "PAR" : "IMPAR";
        $msgresultado .= " RESULTADO DE LA APUESTA : " . $resultado . "<br>";
        if ($apuesta == $resultado) {
            $msgresultado .= "GANASTE <br>";
            $saldodisponible  += $valorapuesta;
        } else {
            $msgresultado .="PERDISTE <br>";
            $saldodisponible  -= $valorapuesta;
        }
    }
  return $msgresultado;
}

function dejarCasino ($visitasrealizadas){
    echo "Muchas gracias por jugar con nosotros. <br> ";
    echo "Su resultado final es de ".$_SESSION['disponible']." Euros <br>";
    $visitasrealizadas++;
    setcookie("visitascasino",$visitasrealizadas, time()+ 30 * 24 * 3600); // Un mes
    session_destroy();
}
