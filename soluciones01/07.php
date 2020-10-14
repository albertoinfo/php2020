<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="refresh" content="2"/>
<style>

table, td, th {
	border: 0px;
}
</style>
</head>
<body>
   <?php
   $red = random_int(50,500);
   $green = random_int(50,500);
   $blue = random_int(50,500);
   ?>
    <table style="background-color:red">
		<tr>
			<td  width="<?php echo $red ?>px" height="40px"> &nbsp; Rojo(<?=$red?>)</td>
		</tr>
	</table>
   <table style="background-color:green">
		<tr>
			<td  width="<?php echo $green ?>px" height="40px"> &nbsp;Verde(<?=$green?>) </td>
		</tr>
	</table>	
	<table style="background-color:blue">
		<tr>
			<td  width="<?php echo $blue ?>px" height="40px"> &nbsp;Azul(<?=$blue?>) </td>
		</tr>
	</table>
   
<hr>
<?php show_source(__FILE__); ?>
<hr>
</body>
</html>
