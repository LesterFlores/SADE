<?php
$id_alumno = !empty($_POST['alumno']) ? $_POST['alumno'] : '';
$ciclo = !empty($_POST['ciclo']) ? $_POST['ciclo'] : '';

if ($ciclo && $id_alumno) {
    include('../db_connect.php');
    
    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // 1. Llamar al procedimiento almacenado para Asignar Alumnos a un ciclo
        $consulta_asignar = "CALL AsignarAlumno(?, ?)";
        $stmt_asignar = $conn->prepare($consulta_asignar);
        $stmt_asignar->bind_param("ss", $ciclo, $id_alumno);

        if ($stmt_asignar->execute()) {
            echo 'Alumno asignado correctamente';
            $stmt_asignar->close();
        } else {
            throw new Exception('Error al Asignar Alumno: ' . $stmt_asignar->error);
        }

        // Confirmar la transacción
        $conn->commit();
        
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo 'Error: ' . $e->getMessage();
    } finally {
        $conn->close();
    }
} else {
    echo 'Datos incompletos. Verifique todos los campos.';
}

header('Location: registro.php');

?>