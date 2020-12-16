<h2 class="text-center text-primary">Tienda on-line <b>La Estilográfica</b></h2>
<br>
<?php // Tienda ///////////////////////////////////////////////////////

  // Vuelca el contenido da la tabla catalogo en el array $producto
  $db = new mysqli("localhost", "root", "root","tienda");
 
  if ($db->connect_error ){
      printf("Conexión fallida: %s\n", $db->connect_error());
      exit();
  }
  $db->set_charset('utf8');
  $datosTienda = "SELECT codigo, nombre, precio, imagen, detalle FROM catalogo";
  $result= $db->query($datosTienda);
    
 
  while ($registro = $result->fetch_assoc()) {
    $productos [$registro['codigo']] = array(
      "nombre" => $registro['nombre'],
      "precio" => $registro['precio'],
      "imagen" => $registro['imagen'],
      "detalle" => $registro['detalle']
    );
  }

  $_SESSION['producto'] = $productos;

  // Muestra el catálogo de productos de la tienda.
  ?>
  <div class="row">
    <div class="col-md-7">
      <?php
      foreach ($productos as $codigo => $elemento) {
      ?>
        <div class="panel-info">
          <div class="panel-heading"><h4><?=$elemento['nombre']?></h4></div>
          <div class="panel-body">
            <table class="table-condensed">
              <tr>
                <td>
                  <h4><?=$elemento['precio']?>€</h4>
                </td>
                <td>
                  <img src="img/<?=$elemento['imagen']?>" width="360">
                </td>
                <td>
                  <form action="pagina.php" method="post">
                    <input type="hidden" name="ejercicio" value="03_detalle">
                    <input type="hidden" name="codigo" value="<?=$codigo?>">
                    <input type="hidden" name="accion" value="detalle">
                    <button type="submit" class="btn btn-info">Detalle</button>
                  </form>
                </td>
                <td>
                  <form action="pagina.php" method="post">
                    <input type="hidden" name="ejercicio" value="03">
                    <input type="hidden" name="codigo" value="<?=$codigo?>">
                    <input type="hidden" name="accion" value="comprar">
                    <button type="submit" class="btn btn-success">Comprar</button>
                  </form>
                </td>
              </tr>
            </table>

          </div>
        </div>
        <?php
      }
      ?>
    </div>
    
    <div class="col-md-1"></div>
    
    <div class="col-md-4">


      <?php // Carrito ///////////////////////////////////////////////////////
      
      $accion ="";
      $codigo ="";
      if ( isset($_POST['accion']) ){
      $accion = $_POST['accion'];
      $codigo = $_POST['codigo'];
      }

      // Inicializa el carrito la primera vez con
      // Todos los productos a 0
      if (!isset($_SESSION['carrito'])) {
        foreach ($productos as $cod => $value) {
          $_SESSION['carrito'][$cod] = 0;
        }
      }

      if ($accion == "comprar") {
          if (isset($_SESSION['carrito'][$codigo]))
               $_SESSION['carrito'][$codigo]++;
          else 
              $_SESSION['carrito'][$codigo]=1;
      }

      if ($accion == "eliminar") {
        $_SESSION['carrito'][$codigo] = 0;
      }

      // Muestra el contenido del carrito
      $total = 0;
      ?>
      <div class="panel-success">
          <div class="panel-heading">
            <h4>Carrito <span class="glyphicon glyphicon-shopping-cart"></span></h4>
          </div>
          <div class="panel-body">
            <?php
            foreach ($productos as $cod => $elemento) {
              if (isset($_SESSION['carrito'][$cod]) &&
                  $_SESSION['carrito'][$cod] > 0) {
                $total = $total + ($_SESSION['carrito'][$cod] * $elemento['precio']);
                ?>
                <img src="img/<?=$elemento['imagen']?>" width="200"><br>
                <?=$elemento['nombre']?><br>Precio: <?=$elemento['precio']?> €<br>
                Unidades: <?=$_SESSION['carrito'][$cod]?>
                <form action="pagina.php" method="post">
                  <input type="hidden" name="ejercicio" value="03">
                  <input type="hidden" name="codigo" value="<?=$cod?>">
                  <input type="hidden" name="accion" value="eliminar">
                  <button type="submit" class="btn btn-danger">
                    <span class="glyphicon glyphicon-trash"></span>
                    Eliminar
                  </button>
                </form><br><br>
                <?php
              }
            }
            ?>
            <div class="panel-footer"><b>Total: <?=$total?> €</b></div>
          </div>
      </div>
    </div>
  </div>