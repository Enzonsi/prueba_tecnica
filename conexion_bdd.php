<?php
$servername = "localhost";
$username = "tu_usuario";
$password = "tu_contraseña";
$dbname = "tu_base_de_datos";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
$nombreApellido = $_POST["nombreApellido"];
$alias = $_POST["alias"];
$rut = $_POST["rut"];
$email = $_POST["email"];
$region = $_POST["region"];
$comuna = $_POST["comuna"];
$comoSeEntero = $_POST["comoSeEntero"];

$sql = "INSERT INTO tabla (nombre_apellido, alias, rut, email, region, comuna, como_se_entero) VALUES ('$nombreApellido', '$alias', '$rut', '$email', '$region', '$comuna', '$comoSeEntero')";

if (mysqli_query($conn, $sql)) {
    echo "Registro creado satisfactoriamente";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>