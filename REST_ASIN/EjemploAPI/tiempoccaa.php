<?php

/* -----------------------------------------------------------------------------
Ejemplo de consulta del API de Aemet para predición meteológica por comunidades

https://opendata.aemet.es/dist/index.html#!/predicciones-normalizadas-texto
------------------------------------------------------------------------------*/
$lugar= "mad";
if ( isset ($_GET['lugar'])){
    $lugar = $_GET['lugar'];
}

// USO de la libreria CURL segun el ejemplo de AEMET

// PRIMERA PETICIÓN 
// Mi clave 
$miclave="eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJhbGJlcnRvLmxvcGV6QGllc3RldHVhbi5lcyIsImp0aSI6IjQ4MzI0ZWE5LTM3YjYtNDVmNy05MmZlLTMzOGI1MjFlZDEyNSIsImlzcyI6IkFFTUVUIiwiaWF0IjoxNjEyODk0Nzg0LCJ1c2VySWQiOiI0ODMyNGVhOS0zN2I2LTQ1ZjctOTJmZS0zMzhiNTIxZWQxMjUiLCJyb2xlIjoiIn0.lcYJszgmj0nZx4fGE_HzJ20EulrR-gzkAif1rON8DB0";
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');

// DETRAS DEL PROXY DEBERIAMOS INCLUIR
//$proxy = "192.168.105.1:3128"
// curl_setopt($ch, CURLOPT_PROXY, $proxy);


curl_setopt_array($curl, array(
  CURLOPT_URL => "https://opendata.aemet.es/opendata/api/prediccion/ccaa/hoy/".$lugar."?api_key=".$miclave,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
  die();
}
$resu =  json_decode($response);


//  SEGUNDA PETICIÓN la dirección de los datos No NECESITA CLAVE
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');

curl_setopt_array($curl, array(
  CURLOPT_URL => $resu->datos,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$prediccion = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
  die();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<pre>
<?=  utf8_encode ( $prediccion); ?>
</pre>
</body>
</html>
