<html>
<head>
<meta charset="UTF-8">
<title>Ejercicio 04 - Genera 666</title>
</head>

<body>
	<h1>Ejercicio 4</h1>
	<code>
		<?php
$contadorintentos = 0;
$contador6 = 0;
$tiempoantes = microtime(true);
$numAnterior = 0;
do {
    $numero = random_int(1, 10);
    $contadorintentos ++;
    if ($numero == 6) {
        if ($numAnterior == 6){
            // Hay otro seis
            $contador6++;
        }
        else {
            // Hay un seis
            $contador6 = 1;
        }
    }
    else {
        // No hay seis
        $contador6 = 0;
    }
    $numAnterior = $numero;
} while ($contador6 < 3);
$tiempoInvertido = microtime(true)-$tiempoantes;
echo "Han salido tres 6 seguidos tras generar ".$contadorintentos." números en ".
        ($tiempoInvertido * 1000) . " milisegundos.";
?>
		</code>
<hr>
<?php show_source(__FILE__); ?>
<hr>
</body>
</html>
