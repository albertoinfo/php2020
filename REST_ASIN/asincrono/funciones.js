function enviarmas(){
    fetch("pruebafetch.php?oper=suma")
  }

function enviarmenos(){
    fetch("pruebafetch.php?oper=resta")
    .catch(function(err) {
          console.error(err);
      });
    
  }
  
  async function ver(){
    
    var response = await fetch('pruebafetch.php?oper=verajax');
    if (response.ok) {
        
        var respuesta = await response.json();
        alert("La cantidad almacenada es " + respuesta.cantidad);
    
    } 
  
  }