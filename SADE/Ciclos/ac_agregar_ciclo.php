<?php
    $grado = !empty($_POST['grado']) ? $_POST['grado'] : '';
    $profesor = !empty($_POST['profesor']) ? $_POST['profesor'] : '';
    $anio = !empty($_POST['anio']) ? $_POST['anio'] : '';
    $seccion = !empty($_POST['seccion']) ? $_POST['seccion'] : '';
   

    if ($grado && $profesor && $anio && $seccion) {
        include('../db_connect.php');
        
         // Iniciar una transacción
         $conn->begin_transaction();

         try {
                 // 2. Llamar al procedimiento almacenado para insertar en tbl_alumnos
                 $consulta_ciclo = "CALL InsertarCiclos(?, ?, ?, ?)";
                 $stmt_ciclo = $conn->prepare($consulta_ciclo);
                 $stmt_ciclo->bind_param("ssss", $grado, $profesor, $anio, $seccion);
                 if ($stmt_ciclo->execute()) {
                     echo 'Registro guardado correctamente';
                     $stmt_ciclo->close();
                 } else {
                     throw new Exception('Error al Guardar Ciclo: ' . $stmt_ciclo->error);
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

    header('Location: ciclo.php')
?>
