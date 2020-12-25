<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='ALTA' method="POST" action="index.php?orden=Modificar">
ID Usuario : <input type="text" name="user" value="<?= $user ?>"  readonly> > <br>
Nombre     : <input type="text" name="nombre" value="<?= $nombre ?>"><br>
Contraseña : <input type="password" id="clave1" name="clave1" value="<?= $clave1 ?>"><br>
Repetir Contraseña : <input type="password" id="clave2" name="clave2" value="<?= $clave2 ?>"><br>
Correo electrónico : <input type="email"    name="email" value ="<?= $email ?>" ><br>
Estado <select name="estado">
	<option value="A" <?= ($estado == "A")?"selected":"" ?> >Activo</option>
	<option value="B" <?= ($estado == "B")?"selected":"" ?> >Bloqueado</option>
	<option value="I" <?= ($estado == "I")?"selected":"" ?> >Inactivo</option>  
</select>
Plan <select name="plan">
	<option value="0" <?= ($plan == "0")?"selected":""  ?> >Básico</option>
	<option value="1" <?= ($plan == "1")?"selected":""  ?> >Profesional</option>
	<option value="2" <?= ($plan == "2")?"selected":""  ?> >Premium</option>
    <option value="3" <?= ($plan == "3")?"selected":""  ?> >Máster</option>
</select><br>
	<input type="submit" value=" Guardar ">
	<input type="cancel" value="Cancelar" size="10" onclick="javascript:window.location='index.php'" >
</form>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>