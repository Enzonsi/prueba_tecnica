<?php
// Conexión a la base de datos
$host = "localhost";
$user = "nombre_usuario";
$password = "contraseña";
$dbname = "formulario_votacion";
$conn = mysqli_connect($host, $user, $password, $dbname);

// Validación del nombre y apellido
if(empty($_POST['nombre']) || empty($_POST['apellido'])) {
  echo "El nombre y apellido no pueden estar en blanco.";
  exit;
}

// Validación del alias
if(strlen($_POST['alias']) < 6 || !preg_match('/^[a-zA-Z0-9]+$/', $_POST['alias'])) {
  echo "El alias debe tener al menos 6 caracteres y contener letras y números.";
  exit;
}

// Validación del RUT
if(!preg_match('/^\d{1,2}\.\d{3}\.\d{3}[-][0-9kK]{1}$/', $_POST['rut'])) {
  echo "El RUT no es válido.";
  exit;
}

// Validación del correo electrónico
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  echo "El correo electrónico no es válido.";
  exit;
}

// Validación de los combos Región y Comuna
if(empty($_POST['region']) || empty($_POST['comuna'])) {
  echo "Debe seleccionar una región y una comuna.";
  exit;
} else {
  $region = $_POST['region'];
  $comuna = $_POST['comuna'];
  $query = "SELECT * FROM comunas WHERE region = '$region' AND comuna = '$comuna'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) == 0) {
    echo "La comuna seleccionada no corresponde a la región seleccionada.";
    exit;
  }
}

// Validación del combo Candidato
if(empty($_POST['candidato'])) {
  echo "Debe seleccionar un candidato.";
  exit;
}

// Validación del checkbox Como se enteró de nosotros
if(empty($_POST['entero'])) {
  echo "Debe seleccionar al menos dos opciones.";
  exit;
} else if(count($_POST['entero']) < 2) {
  echo "Debe seleccionar al menos dos opciones.";
  exit;
}

// Validación de duplicación de votos por RUT
$rut = $_POST['rut'];
$query = "SELECT * FROM votos WHERE rut = '$rut'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0) {
  echo "Ya ha votado con este RUT.";
  exit;
}

// Si se han pasado todas las validaciones, se inserta el voto en la base de datos
$alias = $_POST['alias'];
$email = $_POST['email'];
$candidato = $_POST['candidato'];
$entero = implode(',', $_POST['entero']);
$query = "INSERT INTO votos (nombre, apellido, alias, rut, email, region, comuna, candidato, entero) 
          VALUES ('$_POST[nombre]', '$_POST[apellido]', '$alias', '$_POST[rut]', '$email', '$_POST[region]', 
          '$_POST[comuna]', '$candidato', '$entero')";
mysqli_query($conn, $query);
echo "Gracias por votar!";
?>
