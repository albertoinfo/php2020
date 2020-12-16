function confirmarBorrar(nombre){
  if (confirm("¿Quieres eliminar el cliente:  "+nombre+"?"))
  {
   return true;
  }
 return false;
}