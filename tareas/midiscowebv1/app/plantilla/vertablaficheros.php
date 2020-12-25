<?PHP
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
?>
<h2> GESTIÓN DE FICHEROS DEL USUARIO <?= $_SESSION['user']?></h2> 
<div id='info'><b><?= (isset($_GET['msg']))?$_GET['msg']:""; ?></b></div>
<form name='f1'      action='index.php'>
<input type='hidden' name='operacion' value='Modificar'> 
<input type='submit' value='Modificar mis datos' >
</form>

<form name='f3'      action='index.php'>
<input type='hidden' name='operacion' value='Cerrar'> 
<input type='submit' value='Cerrar Sesión'>
</form>

<table>
<th>Nombre</th><th>Tipo</th><th>Tamaño</th><th>Fecha</th><th>Operaciones</th><th></th><th></th>
<?php foreach ($arrayficheros as $datof ):?>
<tr>
<td><a href="./index.php?operacion=Descargar&nombre=<?=urlencode($datof['nombre'])?>"> <?=$datof['nombre']?> </a></td>
<td> <?=$datof['tipo']?> </td>
<td class="der"> <?=number_format($datof['tamaño'], 0, ',', '.')?></td>
<td> <?= $datof['fecha']?> </td>
<td><a href="#" onclick="confirmarBorrarFile('<?=$datof['nombre']?>');" > Borrar </a></td>
<td><a href="#" onclick="nuevoNombre('<?=$datof['nombre']?>');" 		> Renombrar </a></td>
<td><a href="./index.php?operacion=Compartir&nombre=<?=urlencode($datof['nombre'])?>" > Compartir </a></td>
</tr>
<?php endforeach;?>
</table><br>
Total <b><?=count($arrayficheros)?>
</b> ficheros que ocupan <?=number_format($tamañototal, 0, ',', '.')?> bytes.<br>

<form  enctype="multipart/form-data" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?=TAMMAXIMOFILE ?>" /> 
    <input name="nuevofichero" type="file" /> 
    <input type="submit" value="Subir" />
    </form>
</body>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>
