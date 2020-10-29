<?php
    // Equivale la funcion max($array)
    function valorMaximo ($tabla) {
        $valor = $tabla[0];
        for ($i = 0; $i < count($tabla); $i++) {
            if ($tabla[$i] > $valor) {
                $valor = $tabla[$i];
            }
        }
        return $valor;
    }
    // Equivale la funcion min($array)
    function valorMinimo ($tabla) {
        $valohttp://www.e-recursos.net/cursos4/my/r = $tabla[0];
        for ($i = 0; $i < count($tabla); $i++) {
            if ($tabla[$i] < $valor) {
                $valor = $tabla[$i];
            }
        }
       
        return $valor;
    }
    //Devuelve el número que mas veces se repite
    function valorRepetido ($tabla) {
        $maxrepes = 0;
        $valor =0;
        for ($i = 0; $i < count($tabla); $i++) {
            $veces = 0;
            for ($j = 0; $j < count($tabla); $j++) {
                if ($tabla[$i] == $tabla[$j]) {
                    $veces++;
                }    
            }
            if ($veces > $maxrepes) {
                $valor = $tabla[$i];
            }
        }
        return $valor;
    }
  ?>  


<html>
<head>
<meta charset="UTF-8">
<title>Máximo y mínimo de una tabla</title>
</head>
<body>
  
  <?php  
    define ('TAMAÑO',20);
    $numeros = [];
   
    for ($i = 0; $i < TAMAÑO; $i++) {
        $numeros[] = rand (1,10);
    }
    //Muestro la tabla
    echo "<table style='border: 1px solid black; border-collapse:collapse';><tr>";
    for ($i = 0; $i<count($numeros);$i++) {
        echo "<td style='border: 1px solid black; padding: 5px';>",$numeros[$i]."</td>";
    }
    echo "</tr></table>";
    $maximo = max($numeros);
    $minimo = valorMinimo($numeros);
    $repetido = valorRepetido($numeros);
    echo "<br> Máximo = $maximo <br> Mínimo = $minimo <br> Moda = $repetido "  
?>
<hr>
<?php show_source(__FILE__); ?>
<hr>
</body>
</html>
