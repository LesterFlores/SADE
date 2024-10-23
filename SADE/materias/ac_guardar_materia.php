<?php
$grado = !empty($_POST['grado']) ? $_POST['grado'] : '';
$materia = !empty($_POST['materia']) ? $_POST['materia'] : '';

if ($grado && $materia) {
    include('../db_connect.php');
    
    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // 1. Llamar al procedimiento almacenado para insertar en tbl_responsables
        $consulta_materia = "CALL InsertarMateria(?)";
        $stmt_materia = $conn->prepare($consulta_materia);
        $stmt_materia->bind_param("s", $materia);

        if (!$stmt_materia->execute()) {
            throw new Exception('Error al guardar materia: ' . $stmt_materia->error);
        }
        $stmt_materia->close();

        // Obtener el último ID insertado
        $result = $conn->query("SELECT LAST_INSERT_ID() as codigo_materia");
        if (!$result) {
            throw new Exception('Error al obtener el código de la materia');
        }
        
        $row = $result->fetch_assoc();
        $codigo_materia = $row['codigo_materia'];
        $result->free();

        // 2. Llamar al procedimiento almacenado para asignar materia a un grado
        $consulta_asignar = "CALL AsignarMateria(?, ?)";
        $stmt_asignar = $conn->prepare($consulta_asignar);
        $stmt_asignar->bind_param("ii", $grado, $codigo_materia);

        if (!$stmt_asignar->execute()) {
            throw new Exception('Error al asignar materia: ' . $stmt_asignar->error);
        }
        $stmt_asignar->close();

        // Confirmar la transacción
        $conn->commit();

        // Redirigir después de completar todo el proceso
        header('Location: materias.php');
        exit(); // Detener la ejecución después de la redirección

    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo 'Error: ' . $e->getMessage();
    } finally {
        $conn->close();
    }
} else {
    echo 'Datos incompletos. Verifique todos los campos.';
    exit(); // Detener la ejecución si los datos son incompletos
}
