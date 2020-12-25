<?php
ob_start();
?>
<h2> Detalles </h2>
<table>
<tr><td>Id   </td><td> <?= $userid ?></td></tr>
<tr><td>Nombre   </td><td>   <?= $nombre ?></td></tr>
<tr><td>Correo electrónico:  </td><td>     <?= $email ?></td></tr>
<tr><td>Plan    </td><td>    <?= $plan  ?></td></tr>
<tr><td>Estado   </td><td>   <?= $estado ?></td></tr>
<tr><td>Nº de Ficheros  </td><td> <?= $nficheros ?>(<?=$pficheros ?>%)</td></tr>
<tr><td>Espacio utilizado  </td><td>  <?= $nbytes ?> Bytes (<?= $pespacio ?>%)</td></tr>
</table>
<input type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'" >
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido

$contenido = ob_get_clean();
include_once "principal.php";

?>