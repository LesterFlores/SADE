<?php
include '../db_connect.php'; // Incluye la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $asistencias = $_POST['asistencia'] ?? []; // Alumnos que asistieron o no

    // Recorremos los valores enviados por el formulario
    foreach ($asistencias as $codigo_alumno => $estado_asistencia) {
        // Verificar si ya se guardó asistencia para este alumno hoy
        $fecha_actual = date('Y-m-d');
        $verificar_asistencia = "SELECT * FROM tbl_asistencias WHERE codigo_alumno = ? AND fecha_asistencia = CURDATE()";
        
        $stmt_verificar = $conn->prepare($verificar_asistencia);
        $stmt_verificar->bind_param("i", $codigo_alumno); // Vincula el parámetro
        $stmt_verificar->execute();
        $resultado = $stmt_verificar->get_result();

        if ($resultado->num_rows == 0) {
            // Si no hay asistencia para este día, insertamos la asistencia usando el procedimiento almacenado
            $insertar_asistencia = "CALL InsertarAsistencia(?, ?)"; // Usamos el procedimiento almacenado
             // $estado_asistencia ya viene desde el formulario (1 o 0 según el checkbox)
            $stmt_asistencia = $conn->prepare($insertar_asistencia);
            $stmt_asistencia->bind_param("ii", $codigo_alumno, $estado_asistencia); // Vincula los parámetros
            $stmt_asistencia->execute();
            $stmt_asistencia->close(); // Cerrar el statement de inserción
        }
        
        $stmt_verificar->close(); // Cerramos la consulta de verificación
    }

    // Redirigir o mostrar mensaje de éxito
    header('Location: asistenc.php?mensaje=guardado');
    exit;
}
?>
