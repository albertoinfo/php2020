<?php
$deportes = array(
    'Baloncesto' => "img/baloncesto.jpeg",
    'F1' => "img/f1.jpeg",
    'Futbol' => "img/futbol.jpeg",
    'Tenis' => "img/tenis.jpeg",
    'Volley' => "img/volley.jpeg",
);
?>
<html>
	<head>
		<style type="text/css">
		  table,th,td{
		      border:1px solid black;
		      border-collapse:collapse;
		  }
		  img{
		   display:block;
		   margin-left:auto;
		   margin-right:auto;
		   heigth:80;
		   width:80;
		  }
		</style>
	</head>
	<table>
		<tr>
			<th>Deporte</th>
			<th>logo</th>
		</tr><?php 
		foreach($deportes as $c => $v){?>
		<tr>
			<td><?php echo $c ?></td>
			<td> <img src="<?php echo $v ?>" alt="<?php echo $c ?>"></td>
		</tr>
<?php }?>
	</table>
</html>