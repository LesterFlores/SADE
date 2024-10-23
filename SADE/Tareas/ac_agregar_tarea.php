<?php
    $tarea = !empty($_POST['tarea']) ? $_POST['tarea'] : '';
    $descripcion = !empty($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $punteo = !empty($_POST['punteo']) ? $_POST['punteo'] : '';
    $grado = !empty($_POST['codigo_ciclo']) ? $_POST['codigo_ciclo'] : '';
    $materia = !empty($_POST['codigo_materia']) ? $_POST['codigo_materia'] : '';
    $unidad = !empty($_POST['unidad']) ? $_POST['unidad'] : '';

    $mensaje = '';
    
    if ($tarea && $descripcion && $punteo && $grado && $materia && $unidad) {
        include('../db_connect.php');

        // Iniciar una transacción
        $conn->begin_transaction();

        try {
            // Validar si el punteo total en tbl_nota_total para la materia y unidad supera los 100 puntos
            $consulta_punteo = "SELECT zona_total 
                                FROM tbl_nota_total
                                WHERE codigo_materia = ? AND unidad = ?";
            $stmt_punteo = $conn->prepare($consulta_punteo);
            $stmt_punteo->bind_param("ii", $materia, $unidad);
            $stmt_punteo->execute();
            $resultado_punteo = $stmt_punteo->get_result();
            $fila_punteo = $resultado_punteo->fetch_assoc();
            $total_punteo_actual = $fila_punteo['zona_total'] ?? 0;

            // Verificar si el punteo excede los 100 puntos
            if (($total_punteo_actual + $punteo) > 100) {
                throw new Exception('El punteo total por materia y unidad no puede exceder los 100 puntos.');
            }

            // Insertar la tarea usando el procedimiento almacenado
            $consulta_tarea = "CALL InsertarTareas(?, ?, ?, ?, ?, ?)";
            $stmt_tarea = $conn->prepare($consulta_tarea);
            $stmt_tarea->bind_param("ssiiii", $tarea, $descripcion, $punteo, $grado, $materia, $unidad);

            if ($stmt_tarea->execute()) {
                $mensaje = 'Registro guardado correctamente';
                $stmt_tarea->close();
            } else {
                throw new Exception('Error al Guardar Tarea: ' . $stmt_tarea->error);
            }

            // Confirmar la transacción
            $conn->commit();

            // Redirigir con mensaje de éxito
            header('Location: tareas.php?mensaje=exito');
            exit;

        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conn->rollback();
            $mensaje = 'Error: ' . $e->getMessage();

            // Redirigir con mensaje de error
            header('Location: tareas.php?mensaje=error&detalle=' . urlencode($mensaje));
            exit;
        } finally {
            $conn->close();
        }
    } else {
        // Redirigir con mensaje de datos incompletos
        header('Location: tareas.php?mensaje=error&detalle=' . urlencode('Datos incompletos. Verifique todos los campos.'));
        exit;
    }

    header('Location: tareas.php');
?>
