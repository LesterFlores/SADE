<?php

    $id_ciclo = !empty($_GET['id']) ? $_GET['id'] : '';
    
    if ($id_ciclo) {
        include('../db_connect.php');
            
        // 2. Llamar al procedimiento almacenado para actualizar en tbl_alumnos
        $consulta_ciclo = "CALL InhabilitarCiclo(?)"; 
        $stmt_ciclo = $conn->prepare($consulta_ciclo);
        $stmt_ciclo->bind_param("i", $id_ciclo);

        if ($stmt_ciclo->execute()) {
            $stmt_ciclo->close();
            
            // Si todo fue exitoso, confirmar la transacción
            $conn->commit();
            echo "Los datos han sido actualizados correctamente.";
        } else {
            throw new Exception('Error al actualizar los datos del ciclo.');
        }
        
    } else {
        echo "Por favor, rellene todos los campos requeridos.";
    }

    header('Location: ciclo.php');
?>
