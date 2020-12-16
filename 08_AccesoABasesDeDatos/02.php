<h3 class="text-center">Mantenimiento de clientes</h3>
<?php

$db = new mysqli("localhost", "root", "root","banco");
$db->set_charset("utf8");

if(!isset($_SESSION['pagina'])) {
    $_SESSION['pagina'] = 1;
}

if ( isset ($_POST['accion'])){
    
    switch ( $_POST['accion']){
        case "Nuevo cliente":
            $consulta = "SELECT dni FROM cliente WHERE dni ='".$_POST['dni']."'";
            $resu =$db->query($consulta);
            // Si el DNI introducido ya existe en la BBDD, se muestra una ventana indicando el error.
            if ($resu->num_rows == 1) {
                echo '<script type="text/javascript">alert("Lo siento, ese DNI ya existe en la base de datos");</script>';
            } else {
            $inserta = "INSERT INTO cliente VALUES (\"$_POST[dni]\", \"$_POST[nombre]\", \"$_POST[direccion]\", \"$_POST[telefono]\")";
            $resu = $db->query($inserta);
            }
            break;
        case "Modificar":
            $modifica = "UPDATE cliente SET  nombre=\"$_POST[nombre]\", direccion=\"$_POST[direccion]\", telefono=\"$_POST[telefono]\" WHERE dni=\"$_POST[dni]\"";
            $resu = $db->query($modifica);
            break;
        case "Eliminar":
            $borra = "DELETE FROM cliente WHERE dni=\"$_POST[dni]\"";
            $resu = $db->query($borra);
    }
    if ( $resu === false){
        echo '<script type="text/javascript">alert("'.$db->error.'");</script>';
    }
}
  
  
  // Determina la página que se muestra
  // Cuento cuantos clientes tengo
  $listadoClientes = "SELECT count(*) total FROM cliente";
  $resu = $db->query($listadoClientes);
  $fila = $resu->fetch_assoc();
  $numClientes = $fila['total'];
  $numPaginas = floor(abs($numClientes - 1) / 5) + 1;
  if ( isset($_POST['pagina'])){
  $pagina = $_POST['pagina'];
  }
  else {
  $pagina = "Primera";
  }

  if ($pagina == "Primera") {
    $_SESSION['pagina'] = 1;
  }

  if (($pagina == "Anterior") && ($_SESSION['pagina'] > 1)) {
    $_SESSION['pagina']--;
  }

  if (($pagina == "Siguiente") && ($_SESSION['pagina'] < $numPaginas)) {
    $_SESSION['pagina']++;
  }

  if ($pagina == "Ultima") {
    $_SESSION['pagina'] = $numPaginas;
  }
  
  
  // Listado /////////////////////////////////////////////////
  ?>
  
  <table  class="table table-striped">
    <tr>
      <th>DNI</th>
      <th>Nombre</th>
      <th>Dirección</th>
      <th>Teléfono</th>
      <th></th>
      <th></th>
    </tr>
    
  <?php
    $listadoClientes = "SELECT dni, nombre, direccion, telefono FROM cliente ORDER BY nombre LIMIT ".(($_SESSION['pagina'] - 1) * 5).", 5";
    $resu= $db->query($listadoClientes);
    
    
    while ($registro= $resu->fetch_array() ) {
      ?>
      <tr>
      <td><?=$registro['dni']?></td>
      <td><?=$registro['nombre']?></td>
      <td><?=$registro['direccion']?></td>
      <td><?=$registro['telefono']?></td>
      <td>
        <form action="pagina.php" method="post" 
              onsubmit="return confirm('¿Quieres eliminar el cliente: <?= $registro['nombre'] ?> ?')" >
          <input type="hidden" name="ejercicio" value="02">
          <input type="hidden" name="dni" value="<?=$registro['dni']?>">
          <input type="hidden" name="accion" value="Eliminar">
          <button type="submit" class="btn btn-danger">
          <span class="glyphicon glyphicon-trash"></span> Eliminar
          </button>
        </form>
      </td>
      <td>
        <form action="pagina.php" method="post">
          <input type="hidden" name="ejercicio" value="02_modificar_cliente">
          <input type="hidden" name="dni" value="<?=$registro['dni']?>">  
          <input type="hidden" name="nombre" value="<?=$registro['nombre']?>">
          <input type="hidden" name="direccion" value="<?=$registro['direccion']?>">
          <input type="hidden" name="telefono" value="<?=$registro['telefono']?>">
          <button type="submit" class="btn btn-warning">
          <span class="glyphicon glyphicon-pencil"></span> Modificar
          </button>
        </form>
      </td>            
      </tr>
      <?php
    }
    ?>

    <!-- Botones para pasar las páginas -->
    <tr><td>Página <?=$_SESSION['pagina']?> de <?=$numPaginas?></td>
    <!-- Primera -->
    <td>
      <form action="pagina.php" method="post">
        <input type="hidden" name="ejercicio" value="02">
        <button type="submit" name="pagina" value="Primera">
          <span class="glyphicon glyphicon-step-backward"></span>
          Primera
        </button>
      </form>
    </td>
    <!-- Anterior -->
    <td>
      <form action="pagina.php" method="post">
        <input type="hidden" name="ejercicio" value="02">
        <button type="submit" name="pagina" value="Anterior">
          <span class="glyphicon glyphicon-chevron-left"></span>
          Anterior
        </button>
      </form>
    </td>
    <!-- Siguiente -->
    <td>
      <form action="pagina.php" method="post">
        <input type="hidden" name="ejercicio" value="02">
        <button type="submit" name="pagina" value="Siguiente">
          Siguiente
          <span class="glyphicon glyphicon-chevron-right"></span>
        </button>
      </form>
    </td>
    <!-- Última -->
    <td>
      <form action="pagina.php" method="post">
        <input type="hidden" name="ejercicio" value="02">
        <button type="submit" name="pagina" value="Ultima">
          Última
          <span class="glyphicon glyphicon-step-forward"></span>
        </button>
      </form>
    </td>      
      
      
    <!-- Añadir un nuevo cliente /////////////////////////////////-->
    <form action="pagina.php" method="post">
      <input type="hidden" name="ejercicio" value="02">
      <input type="hidden" name="accion" value="Nuevo cliente">
    <tr>
      <td><input type="text" name="dni" size="10"></td>
      <td><input type="text" name="nombre"></td>
      <td><input type="text" name="direccion"></td>
      <td><input type="text" name="telefono"  size="12"></td>
      <td colspan="2">
        <button type="submit" class="btn btn-success">
        <span class="glyphicon glyphicon-ok"></span> Nuevo cliente
        </button>
      </td>

    </tr>
    </form>
  </table>

