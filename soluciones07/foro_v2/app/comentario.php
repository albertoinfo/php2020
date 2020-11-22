<form name='mensaje' method="POST">
Tema<br>
 <input type="text" name="tema" size=30 
   value="<?=(isset($_REQUEST['tema']))?$_REQUEST['tema']:''?>" ><br>
Comentario: <br>
<textarea name="comentario" rows="4" cols="50"><?=(isset($_REQUEST['comentario']))?$_REQUEST['comentario']:''?></textarea>
<br><br>
<button name="orden" value="Detalles" >Ver Detalles</button>
<button name="orden" value="Guardar"  >Guardar </button>
<button name="orden" value="Nueva"    >Nueva </button>
<button name="orden" value="Terminar" >Terminar </button>
</form>
