<?php

    $id_alumno = !empty($_GET['id']) ? $_GET['id'] : '';
    echo $id_alumno;
    if ($id_alumno) {
        include('../db_connect.php');
            
        // 2. Llamar al procedimiento almacenado para actualizar en tbl_alumnos
        $consulta_alumno = "CALL HabilitarAlumno(?)"; 
        $stmt_alumno = $conn->prepare($consulta_alumno);
        $stmt_alumno->bind_param("i", $id_alumno);

        if ($stmt_alumno->execute()) {
            $stmt_alumno->close();
            
            // Si todo fue exitoso, confirmar la transacción
            $conn->commit();
            echo "Los datos han sido actualizados correctamente.";
        } else {
            throw new Exception('Error al actualizar los datos del alumno.');
        }
        
    } else {
        echo "Por favor, rellene todos los campos requeridos.";
    }

    header('Location: registro.php');
?>
