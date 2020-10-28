<?php 

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="default.css" rel="stylesheet" type="text/css" />
<title>Ejemplo de formulario</title>
</head>
<body>
	<div id="container" style="width: 600px;">
		<div id="header">
			<h1>DATOS PERSONALES</h1>
		</div>

		<div id="content">
		<?php  if ($_SERVER['REQUEST_METHOD'] == "GET") { ?>
			<form method="post" name="datos" size=15>
				Nombre: &nbsp; <input name="nombre"><br> Apellidos: <input
					name="apellidos" size=30> <br> Edad: <select name="edad">
					<option>Menor de 18</option>
					<option>Entre 18 a 30</option>
					<option>Entre 30 a 55</option>
					<option>Mayor de 55</option>
					</select> 
					<br> Sexo: 
					<input name="sexo"  value="hombre" type=radio  checked="checked">Hombre &nbsp;
					<input name="sexo"  value="mujer"  type=radio>Mujer <br>
					<br> Hobbies:<br>
					<input name="hobbies[]" value="la lectura" type="checkbox"> lectura<br>
				    <input name="hobbies[]" value="ver la tele" type="checkbox">ver la tele<br>
				    <input name="hobbies[]" value="hacer deporte" type="checkbox">hacer deporte <br>
				    <input name="hobbies[]" value="salir de marcha"  type="checkbox">Salir de marcha<br> <br>
				<button>Enviar</button>
			</form>
		<?php }
		     else {
		     $nombre = limpiarEntrada($_POST["nombre"]);
		     $apellidos = limpiarEntrada($_POST["apellidos"]); 
		     $msg = ($_POST['sexo'] == "hombre" )?"Bienvenido":"Bienvenida";
		     $msg .= " $nombre $apellidos ";
		     if ( !isset ($_POST["hobbies"])){
		         $msg .= "no tiene aficiones de nuestra lista.";
		     }
		     else {
		         // Limpio por si acaso, evito la inyección pero:
		         // PROBLEMA LOS Nombre y número de hobbies pueden ser alterados !!!!
		         $thobbies = limpiarArrayEntrada($_POST["hobbies"]);
		         if ( count($thobbies) == 1){
		         $msg .= "su única afición es ". $thobbies[0].".";
                 }
                 else {
                     $msg .= "sus aficiones son ";
                     for ($i=0; $i < count($thobbies)-1; $i++){
                         $msg .= $thobbies[$i].", ";
                       }
                     $msg .= " y ".$thobbies[$i];
          
                     }
                 }
             echo $msg;
		     }
		     
		     
		
		?>
		</div>
	</div>
<hr>
<?php 
// Función para limpiar un valor
function limpiarEntrada($entrada){
    $salida = trim($entrada); // Elimina espacios antes y después de los datos
    $salida = stripslashes($salida); // Elimina backslashes \
    $salida = htmlspecialchars($salida); // Traduce caracteres especiales en entidades HTML
    return $salida;
}
// Función para limpiar todos elementos de un array
function limpiarArrayEntrada(&$entrada){
    $tsalida=[];
    foreach ($entrada as $key => $value ) {
        $tsalida[$key] = limpiarEntrada($value);
    }
    return $tsalida;
}
?>
<hr>
</body>
</html>