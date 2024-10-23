<?php
session_start(); // Asegúrate de que la sesión esté iniciada

// Función para obtener el nombre del usuario
function obtenerNombreUsuario() {
    return isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'Usuario';
}

// Función para obtener el rol del usuario
function obtenerRol() {
    return isset($_SESSION['rol']) ? $_SESSION['rol'] : 'Usuario'; // Cambié 'Usuario' a null si no hay rol
}

?>
