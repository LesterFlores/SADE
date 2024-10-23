<?php 
    $dpi = !empty($_POST['cui']) ? $_POST['cui'] : '';
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellido = !empty($_POST['apellido']) ? $_POST['apellido'] : '';
    $telefono = !empty($_POST['telefono']) ? $_POST['telefono'] : '';
    $fecha_nacimiento = !empty($_POST['nacimiento']) ? $_POST['nacimiento'] : '';
    $direccion = !empty($_POST['direccion']) ? $_POST['direccion'] : '';
    $departamento = !empty($_POST['departamento']) ? $_POST['departamento'] : '';
    $municipio = !empty($_POST['municipio']) ? $_POST['municipio'] : '';
    

    if ($nombre && $apellido && $dpi && $fecha_nacimiento && $direccion && $telefono && $departamento && $municipio) {
        include('../db_connect.php');
        
        // Iniciar una transacción
        $conn->begin_transaction();

        try {
            // 1. Llamar al procedimiento almacenado para actualizar en tbl_responsables
            $consulta_maestro = "CALL ActualizarMaestro(?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_maestro = $conn->prepare($consulta_maestro);
            $stmt_maestro->bind_param("ssssssii", $dpi, $nombre, $apellido, $telefono, $fecha_nacimiento, $direccion, $departamento, $municipio);

            if ($stmt_maestro->execute()) {
                $stmt_maestro->close();

            
                    
                    // Si todo fue exitoso, confirmar la transacción
                    $conn->commit();
                    echo "Los datos han sido actualizados correctamente.";
                   
            } else {
                throw new Exception('Error al actualizar los datos del Maestro.');
            }
        } catch (Exception $e) {
            // En caso de error, revertir la transacción
            $conn->rollback();
            echo "Error en la actualización: " . $e->getMessage();
        }
    } else {
        echo "Por favor, rellene todos los campos requeridos.";
    }

    header('Location: Maestros.php')
?>
