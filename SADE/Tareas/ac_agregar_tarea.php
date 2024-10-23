<?php
    $tarea = !empty($_POST['tarea']) ? $_POST['tarea'] : '';
    $descripcion = !empty($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $punteo = !empty($_POST['punteo']) ? $_POST['punteo'] : '';
    $grado = !empty($_POST['codigo_ciclo']) ? $_POST['codigo_ciclo'] : '';
    $materia = !empty($_POST['codigo_materia']) ? $_POST['codigo_materia'] : '';
    $unidad = !empty($_POST['unidad']) ? $_POST['unidad'] : '';
   

    if ($tarea && $descripcion && $punteo && $grado && $materia && $unidad) {
        include('../db_connect.php');
        
         // Iniciar una transacción
         $conn->begin_transaction();

         try {
                 // 2. Llamar al procedimiento almacenado para insertar en tbl_alumnos
                 $consulta_tarea = "CALL InsertarTareas(?, ?, ?, ?, ?, ?)";
                 $stmt_tarea = $conn->prepare($consulta_tarea);
                 $stmt_tarea->bind_param("ssiiii", $tarea, $descripcion, $punteo, $grado, $materia, $unidad);
                 if ($stmt_tarea->execute()) {
                     echo 'Registro guardado correctamente';
                     $stmt_tarea->close();
                 } else {
                     throw new Exception('Error al Guardar Tarea: ' . $stmt_tarea->error);
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

    header('Location: tareas.php')
?>
