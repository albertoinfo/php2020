<h2 class="text-center">G E S T I S I M A L (+segura) </h2>
<hr>
<?php
    // CONEXIÓN  A LA BASE DE DATOS
    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_STRICT); // Me muestre todos los errores en detalle
    try {
        $db = new mysqli("localhost", "root", "root","gestisimal");
    }catch (mysqli_sql_exception $exp){
        printf("***Error: Conexión fallida a la BD: %s\n", $exp->getMessage());
        exit();
    }
    $db->set_charset('utf8');
    $sqlinserta   = "INSERT INTO articulo VALUES (?, ?, ?, ?, ?)";
    $sqlmodificar = "UPDATE articulo SET descripcion=?, precio_compra=?, precio_venta=?, stock=? WHERE codigo=?";
    $sqlborrar    = "DELETE   FROM articulo WHERE codigo=?";
    $sqlconsulta  = "SELECT * FROM articulo WHERE codigo =?";
    $sqlentradasalida   = "UPDATE articulo SET stock=stock+? WHERE codigo=?";
    
    $stmt_insertar  = $db->prepare($sqlinserta);
    $stmt_modificar = $db->prepare($sqlmodificar);
    $stmt_borrar    = $db->prepare($sqlborrar);
    $stmt_consultar  = $db->prepare($sqlconsulta);
    $stmt_entradasalida  = $db->prepare($sqlentradasalida);
    
    // EVITO Cross-Site Scripting (inserción de código HTML)
    foreach ($_POST as $clave => $valor) {
        $_POST[$clave] = strip_tags($valor);
    }      
    // Evitar SQL injection, en este caso innecesarios por utilizar sentencias preparadas
    foreach ($_POST as $clave => $valor) {
        $_POST[$clave] = $db->escape_string($valor);
    }


 if ( isset ($_POST['accion']) ){ 
     $codigo        = isset($_POST['codigo'])?$_POST['codigo']:"";
     $descripcion   = isset($_POST['descripcion'])?$_POST['descripcion']:"";
     $precio_compra = isset($_POST['precio_compra'])?$_POST['precio_compra']:"";
     $precio_venta  = isset($_POST['precio_venta'])?$_POST['precio_venta']:"";
     $stock         = isset($_POST['stock'])?$_POST['stock']:"";
     $unidades      = isset($_POST['unidades'])?$_POST['unidades']:"";
     
     switch ($_POST['accion']){
     
     case "Nuevo articulo":
          // Comprueba si existe el Artículo
          $stmt_consultar->bind_param("s", $codigo);
          $stmt_consultar->execute();
          $result = $stmt_consultar->get_result();
         // No uso un while por que lo normal es que haya una sola fila
          if ($fila = $result->fetch_assoc()) {
            echo '<script type="text/javascript">alert("Lo siento, ya existe un artículo con ese código en la base de datos");</script>';
          } else {
            $stmt_insertar->bind_param("ssddi", $codigo,$descripcion,$precio_compra,$precio_venta,$stock);
            $stmt_insertar->execute();
          }
        break;
   
     case "Modificar": 
      $stmt_modificar->bind_param("sddis",$descripcion, $precio_compra, $precio_venta, $stock, $codigo);
      $stmt_modificar->execute() or die( "Error de la consulta ");
      break;
    
     case "Eliminar":
      $stmt_borrar->bind_param("s", $codigo);
      $stmt_borrar->execute();
      break;

     case "Entrada": 
      if ($unidades == 0 ) {
        echo '<script type="text/javascript">alert("Debe introducir un número positivo.");</script>';
      } else {
        $stmt_entradasalida->bind_param("is", $unidades,$codigo);
        $stmt_entradasalida->execute();
      }
      break;

     case "Salida":
      // Comprueba si hay suficiente stock consultado en la BD
      $stmt_consultar->bind_param("s", $codigo);
      $stmt_consultar->execute();
      $result =  $stmt_consultar->get_result();
      $articulo = $result->fetch_assoc(); 
      if ( !$articulo){
        echo '<script type="text/javascript">alert("Lo siento, no existe un artículo con ese código en la base de datos");</script>';
        break;  
        }
      if ($articulo['stock'] < $unidades) {
        echo '<script type="text/javascript">alert("Lo siento, no se pueden sacar '.$unidades.' unidades del almacén, sólo hay '.$articulo['stock'].' disponibles.");</script>';
      } else {
          $unidades = $unidades * -1;
          $stmt_entradasalida->bind_param("is", $unidades,$codigo);
          $stmt_entradasalida->execute();
      }
     break;
     } // switch
 } // isset $_POST

    // Determina las paginas que podemos mostrar
    $listado = "SELECT count(*) total FROM articulo";
    $resu = $db->query($listado);
    $fila = $resu->fetch_assoc();
    $numArticulos = $fila['total'];
 
    /**** OTRA FORMAS, MAS O MENOS EFICIENTE ??? 
    $listadoArticulos = "SELECT codigo, descripcion, precio_compra, precio_venta, stock FROM articulo";
    $consulta = $db->query($listadoArticulos);
    if (!$consulta){
        echo " $db->error  <br>";
    }
    $numArticulos = $consulta->num_rows;
    **********/
 
    $numPaginas = floor(abs($numArticulos - 1) / 5 + 1);

    if(!isset($_SESSION['pagina'])) {
        $_SESSION['pagina'] = 1;
    }
    
    if (isset ($_POST['pagina'])){
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
    $listadoArticulos = "SELECT codigo, descripcion, precio_compra, precio_venta, stock FROM articulo ORDER BY codigo LIMIT ".(($_SESSION['pagina'] - 1) * 5).", 5";
    $consulta = $db->query($listadoArticulos)
    ///////////
    ?>

    <table  class="table table-striped">
      <tr>
        <th>Código</th>
        <th>Descripción</th>
        <th>Precio de<br>compra</th>
        <th>Precio de<br>venta</th>
        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Margen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>Stock</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
      </tr>

    <?php
    while ($registro = $consulta->fetch_array()) {
      ?>
      <tr>
        <td><?=$registro['codigo']?></td>
        <td><?=$registro['descripcion']?></td>
        <td><?=$registro['precio_compra']?></td>
        <td><?=$registro['precio_venta']?></td>
        <td><?=($registro['precio_venta'] - $registro['precio_compra'])?></td>
        <td><?=$registro['stock']?></td>
        <td>
          <form action="pagina.php" method="post">
            <input type="hidden" name="ejercicio" value="04_borrar_articulo_confirmacion">
            <input type="hidden" name="codigo" value="<?=$registro['codigo']?>">
            <input type="hidden" name="descripcion" value="<?=$registro['descripcion']?>">
            <input type="hidden" name="precio_compra" value="<?=$registro['precio_compra']?>">
            <input type="hidden" name="precio_venta" value="<?=$registro['precio_venta']?>">
            <input type="hidden" name="stock" value="<?=$registro['stock']?>">
            <button type="submit" class="btn btn-danger">
              <span class="glyphicon glyphicon-trash"></span> Eliminar
            </button>
          </form>
        </td>
        <td>
          <form action="pagina.php" method="post">
            <input type="hidden" name="ejercicio" value="04_modificar_articulo">
            <input type="hidden" name="codigo" value="<?=$registro['codigo']?>">
            <input type="hidden" name="descripcion" value="<?=$registro['descripcion']?>">
            <input type="hidden" name="precio_compra" value="<?=$registro['precio_compra']?>">
            <input type="hidden" name="precio_venta" value="<?=$registro['precio_venta']?>">
            <input type="hidden" name="stock" value="<?=$registro['stock']?>">
            <button type="submit" class="btn btn-warning">
              <span class="glyphicon glyphicon-pencil"></span> Modificar
            </button>
          </form>
        </td>						
        <td>
          <form action="pagina.php" method="post">
            <input type="hidden" name="ejercicio" value="04_entrada_articulo">
            <input type="hidden" name="codigo" value="<?=$registro['codigo']?>">
            <input type="hidden" name="descripcion" value="<?=$registro['descripcion']?>">
            <input type="hidden" name="precio_compra" value="<?=$registro['precio_compra']?>">
            <input type="hidden" name="precio_venta" value="<?=$registro['precio_venta']?>">
            <input type="hidden" name="stock" value="<?=$registro['stock']?>">
            <button type="submit" class="btn btn-primary">
              <span class="glyphicon glyphicon-log-in"></span> Entrada
            </button>
          </form>
        </td>						
        <td>
          <form action="pagina.php" method="post">
            <input type="hidden" name="ejercicio" value="04_salida_articulo">
            <input type="hidden" name="codigo" value="<?=$registro['codigo']?>">
            <input type="hidden" name="descripcion" value="<?=$registro['descripcion']?>">
            <input type="hidden" name="precio_compra" value="<?=$registro['precio_compra']?>">
            <input type="hidden" name="precio_venta" value="<?=$registro['precio_venta']?>">
            <input type="hidden" name="stock" value="<?=$registro['stock']?>">
            <button type="submit" class="btn btn-primary">
              <span class="glyphicon glyphicon-log-out"></span> Salida
            </button>
          </form>
        </td>						
      </tr>
      <?php
    }
    ?>

    <!-- Botones para pasar las páginas -->
    <tr>
      <td>Página <?=$_SESSION['pagina']?> de <?=$numPaginas?></td>
      <td></td>
      <!-- Primera -->
      <td>
        <form action="pagina.php" method="post">
          <input type="hidden" name="ejercicio" value="04s">
          <button type="submit" name="pagina" value="Primera">
            <span class="glyphicon glyphicon-step-backward"></span>
            Primera
          </button>
        </form>
      </td>
      <!-- Anterior -->
      <td>
        <form action="pagina.php" method="post">
          <input type="hidden" name="ejercicio" value="04s">
          <button type="submit" name="pagina" value="Anterior">
            <span class="glyphicon glyphicon-chevron-left"></span>
            Anterior
          </button>
        </form>
      </td>
      <!-- Siguiente -->
      <td>
        <form action="pagina.php" method="post">
          <input type="hidden" name="ejercicio" value="04s">
          <button type="submit" name="pagina" value="Siguiente">
            Siguiente
            <span class="glyphicon glyphicon-chevron-right"></span>
          </button>
        </form>
      </td>
      <!-- Última -->
      <td>
        <form action="pagina.php" method="post">
          <input type="hidden" name="ejercicio" value="04s">
          <button type="submit" name="pagina" value="Ultima">
            Última
            <span class="glyphicon glyphicon-step-forward"></span>
          </button>
        </form>
      </td>      

   
    <!-- Añadir un nuevo articulo -->
    <form action="pagina.php" method="post">
      <input type="hidden" name="ejercicio" value="04s">
    <tr>
      <td><b>Código</b></td>
      <td><b>Descripción</b></td>
      <td><b>Precio de compra</b></td>
      <td><b>Precio de venta</b></td>
      <td></td>
      <td><b>Stock</b></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
      <td><input type="text" name="codigo" size="10"></td>
      <td><input type="text" name="descripcion"></td>
      <td><input type="number" min="0" name="precio_compra" step="0.01" style="width: 7em"></td>
      <td><input type="number" min="0" name="precio_venta" step="0.01"style="width: 7em"></td>
      <td><input type="hidden" name="accion" value="Nuevo articulo"></td>
      <td><input type="number" min="0" name="stock" style="width: 7em"></td>
      <td colspan="2">
        <button type="submit" class="btn btn-success">
        <span class="glyphicon glyphicon-ok"></span> Nuevo artículo
        </button>
      </td>
      <td></td>
      <td></td>
    </form>
    </td>
  </tr>
</table>
     