<html>
<head>
<meta charset="UTF-8">
<title>Ejercicio 2 Funciones</title>
</head>
<body>
<?php
define ('MAXINTENTOS',5);
session_start();

if (!isset ($_SESSION['numeroOculto'])){
    $_SESSION['numeroOculto'] = random_int(1, 20);
    $_SESSION['intentos']     = 0;
    echo "<H1> !! BIENVENIDO !! </H1> ";
  }
  else {
      if ( isset ($_REQUEST['numeroUsuario'])){
          $numu = $_REQUEST['numeroUsuario'];
          $numx = $_SESSION['numeroOculto'];
          $_SESSION['intentos']++;        
          echo " INTENTOS =". $_SESSION['intentos'] ."<br> ";
          if ($numx == $numu){
              echo " Enhorabuena has acertado <br> ";
              session_destroy();
              echo " Se ha generando un nuevo número a adivinar ";
              header("Refresh:3");
              exit();
          } else 
              if ( $_SESSION['intentos'] >= MAXINTENTOS ){
               echo " Superado el número de intentos <br> ";
               session_destroy();
               echo " Se ha generando un nuevo número a adivinar ";
               header("Refresh:3");
               exit();
              }
              else if ( $numx > $numu){
                  echo " No llegas <br> ";
                 } else {
                 echo " Te pasas <br> ";
                 }
          }          
      }
  
?>
<form method="get">
Introduce un número: <input name="numeroUsuario" type="number" size="5">
</form>




    
