<?php 
include_once 'Cliente.php';
include_once 'Pedido.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Listado de Pedidos </title>
</head>
<body>
	<h1>Bienvenido usuario:<?=$cli->nombre; ?> </h1> 
	 Has entrado <?=$cli->veces?> veces en nuestra web <br>
	
	<?php 
	$total =0;
	if ( count($lista) > 0){
	?>
	<b> Esta es su lista de pedidos del cliente con <?= $cli->cod_cliente; ?> </b><br>
	<table border="1">
	<?php 
	foreach ($lista as $p) { ?>
	<tr>
	<td><?= $p->producto; ?></td>
	<td><?= $p->precio;   ?></td>
	</tr>
	<?php $total +=$p->precio;
	}?>  
	
	<tr>
	<td> TOTAL PEDIDOS </td><td><?=$total ?></td>
	</tr>
	</table>
	<?php } 
	else {?>  
     <p> No existen pedidos para este cliente.</p>
	<?php }
?> 

</body>
</html>