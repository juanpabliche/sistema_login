<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "sistema_login");

// Verifica la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Insertar en la base de datos
$sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $nombre, $email, $password);

if ($stmt->execute()) {
    echo "Usuario registrado con éxito.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
