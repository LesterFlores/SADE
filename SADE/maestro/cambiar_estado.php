<?php

    $id_maestro = !empty($_GET['id']) ? $_GET['id'] : '';
    echo $id_maestro;
    if ($id_maestro) {
        include('../db_connect.php');
            
        // 2. Llamar al procedimiento almacenado para actualizar en tbl_profesores
        $consulta_maestro = "CALL InhabilitarMaestro(?)"; 
        $stmt_maestro = $conn->prepare($consulta_maestro);
        $stmt_maestro->bind_param("s", $id_maestro);

        if ($stmt_maestro->execute()) {
            $stmt_maestro->close();
            
            // Si todo fue exitoso, confirmar la transacción
            $conn->commit();
            echo "Los datos han sido actualizados correctamente.";
        } else {
            throw new Exception('Error al actualizar los datos del Maestro.');
        }
        
    } else {
        echo "Por favor, rellene todos los campos requeridos.";
    }

    header('Location: Maestros.php');
?>
