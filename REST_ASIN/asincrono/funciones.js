function enviarmas(){
    fetch("servidor.php?oper=suma")
  }

function enviarmenos(){
    fetch("servidor.php?oper=resta")
    .catch(function(err) {
          console.error(err);
      });
    
  }
  
  async function ver(){
    
    var response = await fetch('servidor.php?oper=verajax');
    if (response.ok) {
        
        var respuesta = await response.json();
        alert("La cantidad almacenada es " + respuesta.cantidad);
    
    } 
  
  }