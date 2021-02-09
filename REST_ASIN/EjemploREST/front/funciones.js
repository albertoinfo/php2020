// Función que convierte el JSON en una tabla HTML
function tablefromJSON(respuesta){

	tobjs = respuesta.data;
	txt ="";
    txt += "<table border='1'>"
    for (n in tobjs) {
      txt += "<tr>"+
             "<td>"+  tobjs[n].cod_cliente+"</td>"+
              "<td>"+ tobjs[n].nombre + "</td>"+
              "<td>"+ tobjs[n].veces  + "</td>"+
              "</tr>";
    }
    txt += "</table>";    
    document.getElementById("resu").innerHTML = txt;
}

function  VerObjectoJSON(respuesta){
	cli = respuesta.data;
	txt ="";
    txt += "<table border='1'>"
    txt += "<tr>"+
    		"<td>"+ cli.cod_cliente+"</td>"+
    		"<td>"+ cli.nombre + "</td>"+
    		"<td>"+ cli.veces  + "</td>"+
            "</tr>";
    
    txt += "</table>";    
    document.getElementById("resu").innerHTML = txt;
}

function getAllRequest()
{  
  
   axios.get('../srv/server.php/clientes/')
     .then(function (response) {
     
      tablefromJSON(response);
      console.log(response);
     })
     .catch(function (error) {
      console.log(error);
     })
     .then(function () {
     });
}

 
function getByIdRequest()
{
  
   id = document.getElementById("codigo").value;
   axios.get('../srv/server.php/clientes/' + id)
     .then(function (response) {
      VerObjectoJSON(response);
      console.log(response);
     })
     .catch(function (error) {
      document.getElementById("resu").innerHTML = error;
      console.log(error);
     })
     .then(function () {
     });
}
 

function putRequest()
{
   id = document.getElementById("codigo").value;
   // El resto de campos se podrían coger de un formulario
   axios.put('../srv/server.php/clientes/' + id, {
     	  nombre: 'Pepillo',
    	  clave :  '34909d',
    	  veces :  '1'
     })
     .then(function (response) {
        tablefromJSON(response);
      console.log(response);
     })
     .catch(function (error) {
      console.log(error);
     })
     .then(function () {
     });
}
 
function deleteRequest()
{
   id = document.getElementById("codigo").value;
   axios.delete('../srv/server.php/clientes/' + id)
     .then(function (response) {
        tablefromJSON(response);
      console.log(response);
     })
     .catch(function (error) {
      console.log(error);
     })
     .then(function () {
     });
}


function postRequest()
{
   id    =  document.getElementById("codigo").value;
   incremento =  document.getElementById("valor") .value;
   axios.post('../srv/server.php/clientes/' + id,
		   {
      valor: incremento
     })
     .then(function (response) {
    	 tablefromJSON(response);
      console.log(response);
     })
     .catch(function (error) {
      console.log(error);
     })
     .then(function () {
     });
}
