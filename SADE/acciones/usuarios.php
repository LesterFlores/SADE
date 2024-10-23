<?php
session_start(); // Iniciar sesión
include('../db_connect.php');

$email = $_POST['email'];
$pass = $_POST['password'];

$sql = "SELECT * FROM tbl_usuarios WHERE correo_electronico = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    
    // Verificar la contraseña cifrada
    if (password_verify($pass, $usuario['contrasena'])) {
        if ($usuario['estado'] == 1 && $usuario['rol'] == 1) {
            // Almacenar el nombre del usuario en la sesión
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario']; // Asegúrate de que este campo exista en tu base de datos
            $_SESSION['rol'] = $usuario['rol'];
            // Usuario activo
            header('Location: ../principal/lobi_admin.php');
            exit; // Detener ejecución
        }else if ($usuario['estado'] == 1 && $usuario['rol'] == 2) {
            // Almacenar el nombre del usuario en la sesión
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario']; // Asegúrate de que este campo exista en tu base de datos
            $_SESSION['rol'] = $usuario['rol'];
            // Usuario activo
            header('Location: ../principal/lobi_maestro.php');
            exit; // Detener ejecución
        } else {
            // Usuario inactivo
            header('Location: ../login/index.php?alerta=desactivado');
            exit; // Detener ejecución
        }
    } else {
        // Contraseña incorrecta
        header('Location: ../login/index.php?alerta=error');
        exit; // Detener ejecución
    }
} else {
    // Usuario no encontrado
    header('Location: ../login/index.php?alerta=error');
    exit; // Detener ejecución
}

$stmt->close();
$conn->close();
?>
