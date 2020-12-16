<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
// FORMULARIO DE ALTA DE USUARIOS
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='ALTA' method="POST" action="index.php?orden=Alta">
<-- COMPLETAR -->	
	
</form>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>