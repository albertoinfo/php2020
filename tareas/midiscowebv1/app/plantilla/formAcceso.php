

<?php 
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
$auto = $_SERVER['PHP_SELF'];
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<div style="text-align:center">
<form name='ACCESO' method="POST" action="index.php">
   <p><a href=<?=$auto?>?orden=Registrarse > Darse de alta</a><p>
	<table  style="margin-left:auto; margin-right:auto">
		<tr>
			<td>Usuario</td>
			<td><input type="text" name="user"
				value="<?= $user ?>"></td>
		</tr>
		<tr>
			<td>Contraseña:</td>
			<td><input type="password" name="clave"
				value="<?= $clave ?>"></td>
		</tr>
	</table>
	<input type="submit" name="orden" value="Entrar">
</form>
</div>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>
