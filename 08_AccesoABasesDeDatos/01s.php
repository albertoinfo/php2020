
<h3 class="text-center">Mantenimiento de clientes (+SEGURO)</h3>
<?php

// Tratamiento de Errores mediante excepciones
mysqli_report(MYSQLI_REPORT_STRICT);
try {
    $db = new mysqli("localhost", "root", "root","banco");
}catch (mysqli_sql_exception $exp){
    printf("***Error: Conexión fallida a la BD: %s\n", $exp->getMessage());
    exit();
}

$db->set_charset("utf8");
// Defino la sentencias precompiladas
$sqlinserta   = "INSERT INTO cliente VALUES (?, ?, ?, ?)";
$sqlmodificar = "UPDATE cliente SET  nombre=?, direccion=?, telefono=? WHERE dni=?";
$sqlborrar    = "DELETE FROM cliente WHERE dni=?";
$sqlconsulta  = "SELECT dni, nombre, direccion, telefono FROM cliente";

$stmt_insertar  = $db->prepare($sqlinserta);
$stmt_modificar = $db->prepare($sqlmodificar);
$stmt_borrar    = $db->prepare($sqlborrar);
$stmt_consulta  = $db->prepare($sqlconsulta);


// EVITO Cross-Site Scripting (inserción de código HTML)
foreach ($_POST as $clave => $valor) {
    $_POST[$clave] = strip_tags($valor);
}
// Evitar SQL injection
foreach ($_POST as $clave => $valor) {
    $_POST[$clave] = $db->escape_string($valor);
}

// Falta validar totalmente los valores y no permitir vacios
if ( isset ($_POST['accion'])){
    $dni =       isset($_POST['dni'])?$_POST['dni']:"";
    $nombre =    isset($_POST['nombre'])?$_POST['nombre']:"";
    $direccion = isset($_POST['direccion'])?$_POST['direccion']:"";;
    $telefono =  isset($_POST['telefono'])?$_POST['telefono']:"";;
    switch ( $_POST['accion']){
        case "Nuevo cliente":
            $stmt_insertar->bind_param("ssss", $dni,$nombre,$direccion,$telefono);
            $stmt_insertar->execute();
            break;
        case "Modificar":
            $stmt_modificar->bind_param("ssss",$nombre,$direccion,$telefono,$dni);
            $stmt_modificar->execute();
            break;
        case "Eliminar":
            $stmt_borrar->bind_param("s", $dni);
            $stmt_borrar->execute();
    }
}
// Listado /////////////////////////////////////////////////i
$stmt_consulta->execute();
$result = $stmt_consulta->get_result() 
?>

<table class="table table-striped">
	<tr>
		<th>DNI</th>
		<th>Nombre</th>
		<th>Dirección</th>
		<th>Teléfono</th>
		<th></th>
		<th></th>
	</tr>
    
  <?php

    while ($registro = $result->fetch_array()) {
      ?>
      <tr>
		<td><?=$registro['dni']?></td>
		<td><?=$registro['nombre']?></td>
		<td><?=$registro['direccion']?></td>
		<td><?=$registro['telefono']?></td>
		<td>
			<form action="pagina.php" method="post">
				<input type="hidden" name="ejercicio" value="01s"> <input
					type="hidden" name="dni" value="<?=$registro['dni']?>"> <input
					type="hidden" name="accion" value="Eliminar">
				<button type="submit" class="btn btn-danger">
					<span class="glyphicon glyphicon-trash"></span> Eliminar
				</button>
			</form>
		</td>
		<td>
			<form action="pagina.php" method="post">
				<input type="hidden" name="ejercicio" value="01s_modificar_cliente">
				<input type="hidden" name="dni" value="<?=$registro['dni']?>"> <input
					type="hidden" name="nombre" value="<?=$registro['nombre']?>"> <input
					type="hidden" name="direccion" value="<?=$registro['direccion']?>">
				<input type="hidden" name="telefono"
					value="<?=$registro['telefono']?>">
				<button type="submit" class="btn btn-warning">
					<span class="glyphicon glyphicon-pencil"></span> Modificar
				</button>
			</form>
		</td>
	</tr>
      <?php
    }
    ?>
        
    <!-- Añadir un nuevo cliente /////////////////////////////////-->
	<form action="pagina.php" method="post">
		<input type="hidden" name="ejercicio" value="01s"> <input type="hidden"
			name="accion" value="Nuevo cliente">
		<tr>
			<td><input type="text" name="dni" size="10"></td>
			<td><input type="text" name="nombre"></td>
			<td><input type="text" name="direccion"></td>
			<td><input type="text" name="telefono" size="12"></td>
			<td colspan="2">
				<button type="submit" class="btn btn-success">
					<span class="glyphicon glyphicon-ok"></span> Nuevo cliente
				</button>
			</td>

		</tr>
	</form>
</table>
