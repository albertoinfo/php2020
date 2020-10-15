<html>
<head>
<meta charset="UTF-8">
<title>Tabla de Paises</title>
</head>

<style type="text/css">
table, th, td {
	border: 1px solid black;
	border-collapse: collapse;
}
</style>
</head>
<?php
include_once 'infopaises.php';
?>
<body>
<h1>Tabla de paises </h1>
	<table>
		<tr>
			<th>País</th>
			<th>Capital</th>
			<th>Población</th>
			<th>Ciudades</th>
		</tr><?php
foreach ($paises as $pais => $infopais) {
    ?>
     <tr>
	 <td><?php echo $pais ?></td>
	 <td><?php echo $infopais['Capital'] ?></td>
	 <td><?php echo $infopais['Poblacion'] ?></td>
	 <td><?php
	       foreach ($ciudades[$pais] as $ciudad) {
           echo $ciudad . ", ";
           }
    ?>
	</td>
	</tr>
<?php }?>
</table>
<hr>
<?php show_source(__FILE__); ?>
<hr>
</body>
</html>

</html>