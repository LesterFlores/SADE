<?php

    $id_ciclo = !empty($_POST['codigo_ciclo']) ? $_POST['codigo_ciclo'] : '';
    $grado = !empty($_POST['grado']) ? $_POST['grado'] : '';
    $profesor = !empty($_POST['profesor']) ? $_POST['profesor'] : '';
    $anio = !empty($_POST['anio']) ? $_POST['anio'] : '';
    $seccion = !empty($_POST['seccion']) ? $_POST['seccion'] : '';

    
    if ($id_ciclo) {
        include('../db_connect.php');
            
        // 2. Llamar al procedimiento almacenado para actualizar en tbl_alumnos
        $consulta_ciclo = "CALL ActualizarCiclo(?, ?, ?, ?, ?)"; 
        $stmt_ciclo = $conn->prepare($consulta_ciclo);
        $stmt_ciclo->bind_param("issss", $id_ciclo, $grado, $profesor, $anio, $seccion);

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
