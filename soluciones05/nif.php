<html>
<head>
<meta charset="UTF-8">
<title>Calcula NIF</title>
</head>
<body>
<?php
function calculaNIF (int $digitos):String{
  
    $letras = ["T","R","W","A","G","M","Y","F","P","D","X","B","N","J","Z","S","Q","V","H","L","C","K","E"];
    $resultado = $letras [$digitos%23];
    return $resultado;
}

if($_SERVER['REQUEST_METHOD'] == "GET"){
?>
 <form  method='POST'>
 <p>DNI: <input type='text' name='dni'></p>
 <input type='submit' value='Enviar'/>
 </form>
<?php 
}
else{
	$numdni   = $_POST["dni"];
	$letradni = calculaNIF($numdni);
	echo "La letra del DNI es: $letradni <br>";
	echo "Su NIF completo sería: $numdni-$letradni";
	}
?>
</body>
</html>	

		
