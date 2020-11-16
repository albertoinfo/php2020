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
        ?>
        <h1> BIENVENIDO AL CASINO</h1> <br>
        Esta es su <?= $visitas ?>º visita.<br>
        <form method="post">
		Introduzca el dinero con el que va jugar:
		 <input name="cantidadini" type="number">
		</form>
		</body>
		</html>
        <?php
        exit();
    } else {
    $_SESSION['disponible'] = $_POST['cantidadini'];
    header("Refresh:0");
    }
}

if (isset($_POST["apostar"])) {
    $cantidad = $_POST["cantidad"];
    if ($cantidad > $_SESSION['disponible']) {
        echo "Error: no dispone de la cantidad necesaria. <br> ";
    } else {
        $apuesta = $_POST['apuesta'];
        $resultado = (random_int(1, 100) % 2 == 0) ? "PAR" : "IMPAR";
        echo " RESULTADO DE LA APUESTA : " . $resultado . "<br>";
        if ($apuesta == $resultado) {
            echo "GANASTE <br>";
            $_SESSION["disponible"] += $cantidad;
        } else {
            echo "PERDISTE <br>";
            $_SESSION["disponible"] -= $cantidad;
        }
    }
    
    
  } 
 // Si abandona o ya no le queda dinero
 if (isset($_POST["dejar"]) || ($_SESSION["disponible"] == 0) ) {
   echo "Muchas gracias por jugar con nosotros. <br> ";
   echo "Su resultado final es de ".$_SESSION['disponible']." Euros <br>";
   $visitas++;
   setcookie("visitascasino",$visitas, time()+ 30 * 24 * 3600); // Un mes
   session_destroy();
   exit();
} 

?>
Dispone de  <?= $_SESSION["disponible"] ?> para jugar
<form method="POST">
Cantidad a apostar :<input name="cantidad" type="number"> <br>
Tipo de apuesta : 
<input  type="radio"   name="apuesta" value="PAR" checked='checked'> Par
<input  type="radio"   name="apuesta" value="IMPAR"> Impar
<button name='apostar' value='apostar' > Apostar cantidad </button>
<button name='dejar'   value='dejar'   > Abandonar el Casino </button>
</form>

</body>
</html>
