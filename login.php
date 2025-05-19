<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "sistema_login");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibe datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Buscar el usuario en la base de datos
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    // Verificar contraseña
    if (password_verify($password, $usuario['password'])) {
        $_SESSION['usuario'] = $usuario['nombre'];
        echo "Bienvenido, " . $_SESSION['usuario'] . "! <a href='logout.php'>Cerrar sesión</a>";
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "El usuario no existe.";
}

$stmt->close();
$conexion->close();
?>
