<?php
echo " Conectando a la base de datos <br>";
$conex = new mysqli("192.168.105.94", "root", "root", "Empresa"); // Abre una conexión
if (mysqli_connect_errno()) {
    // Comprueba conexión
    printf("Conexión fallida: %s\n", mysqli_connect_error());
    exit();
}
$query = "SELECT EMP_NO,APELLIDO FROM EMPLEADOS";
if ($result = $conex->query( $query)) {
    // Sí hay resultados
    $result->data_seek(0);
    while ( $fila = $result->fetch_assoc()) {
        // Apunta a la primera fila
        // Extrae fila apuntada y apunta a la siguiente
        printf ("Nº: %s Apellido: %s <br>", $fila['EMP_NO'], $fila['APELLIDO'] );
        // Muestra sus datos
    }
   
    $result->close(); // libera recursos de la consulta
}
$conex->close(); // cierra conexión
?>