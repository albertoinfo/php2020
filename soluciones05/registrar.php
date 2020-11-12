
<html>
<head>
<meta charset="UTF-8">
<link href="default.css" rel="stylesheet" type="text/css" />
<title>Registrar Usuario</title>
</head>
<body>
<div id="container" style="width: 600px;">
		<div id="header">
			<h1>FORMULARIO DE REGISTRO</h1>
		</div>

		<div id="content">
	
<?php
// Se solicita el formulario contraseña y email tipo text para pruebas
if($_SERVER['REQUEST_METHOD'] == "GET"){ ?>
<form  method="post">
     <fieldset>
     <legend>Datos para registrar:</legend>
	
	<input type="text" name="nombre" placeholder="Nombre" size="10">
	<input type="text" name="email" placeholder="Correo electrónico" size="15"><br>	
	<input type="text" name="contraseña1" placeholder="Contraseña"   size="10"><br>	
	<input type="text" name="contraseña2" placeholder="Contraseña"   size="10"><br>	
	<input type="submit" value="Enviar" />
	</fieldset>
</form>
</div>
</div>
</body>
</html>
<?php 
exit();
}
// Proceso los datos

// No hay valores vacios
foreach ($_POST as $clave => $valor) {
    if (estaVacio($valor)){
        echo "El campo $clave esta vacio ";
        exit;
    }
   }
// No es un email
if ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        echo " No es un email correcto. ";
        exit;
}

// Validando contraseña

if (  $_POST['contraseña1'] != $_POST['contraseña2'] ){
    echo " Las contraseñas deben ser iguales ";
    exit;
}

$clave = $_POST['contraseña1'];
if (  strlen($clave) < 8 ){
    echo "Tamaño de la contraseña debe ser igual o superior a 8 caracteres en total";
    exit;
}

if ( !hayMayusculas($clave) || !hayMinusculas($clave)){
    echo " Debe haber mayúsculas y minúsculas. ";
    exit;
}
if ( !hayDigito($clave)){
    echo " Debe haber algun dígito.";
    exit;
}

if ( !hayNoAlfanumerico($clave)){
    echo " No hay nigún caracter no alfanumérico ";
    exit;       
}
 
echo " Sus datos son correctos. <br> Ha sido registrado en el sistema.";

?>
</div>
</div>
</body>
</html>
<?php  
// Funciones auxilires 

function estaVacio ($valor) {
    return empty(trim($valor));
}

function hayMayusculas ($valor){
    for ($i=0; $i<strlen($valor); $i++){
        if ( ctype_upper($valor[$i]) )
            return true;
    }
    return false;
}

function hayMinusculas ($valor){
    for ($i=0; $i<strlen($valor); $i++){
        if ( ctype_lower($valor[$i]))
            return true;
    }
    return false;
}

function hayDigito ($valor){
    for ($i=0; $i<strlen($valor); $i++){
        if ( ctype_digit($valor[$i]) )
            return true;
    }
    return false;
}

function hayNoAlfanumerico ($valor){
    for ($i=0; $i<strlen($valor); $i++){
        if ( !ctype_alnum($valor[$i]) )
            return true;
    }
    return false;
}


?>


