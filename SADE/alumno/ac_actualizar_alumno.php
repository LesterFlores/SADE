<?php
    $codigo_responsable = !empty($_POST['id_responsable']) ? $_POST['id_responsable'] : '';
    $dpi = !empty($_POST['dpi']) ? $_POST['dpi'] : '';
    $nombre_padre = !empty($_POST['nombre-padre']) ? $_POST['nombre-padre'] : '';
    $apellido_padre = !empty($_POST['apellido-padre']) ? $_POST['apellido-padre'] : '';
    $parentezco = !empty($_POST['parentesco']) ? $_POST['parentesco'] : '';
    $telefono = !empty($_POST['telefono']) ? $_POST['telefono'] : '';

    $id_alumno = !empty($_POST['id_alumno']) ? $_POST['id_alumno'] : '';
    $cui = !empty($_POST['cui']) ? $_POST['cui'] : '';
    $nombre = !empty($_POST['nombres']) ? $_POST['nombres'] : '';
    $apellido = !empty($_POST['apellidos']) ? $_POST['apellidos'] : '';
    $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '';
    $direccion = !empty($_POST['direccion']) ? $_POST['direccion'] : '';
    $departamento = !empty($_POST['departamento']) ? $_POST['departamento'] : '';
    $municipio = !empty($_POST['municipio']) ? $_POST['municipio'] : '';

    

    if ($id_alumno && $nombre && $apellido && $cui && $dpi && $fecha_nacimiento && $parentezco && $nombre_padre && $apellido_padre && $direccion && $telefono && $departamento && $municipio) {
        include('../db_connect.php');
        
        // Iniciar una transacción
        $conn->begin_transaction();

        try {
            // 1. Llamar al procedimiento almacenado para actualizar en tbl_responsables
            $consulta_responsable = "CALL ActualizarResponsable(?, ?, ?, ?, ?, ?)";
            $stmt_responsable = $conn->prepare($consulta_responsable);
            $stmt_responsable->bind_param("isssis", $codigo_responsable, $dpi, $nombre_padre, $apellido_padre, $parentezco, $telefono);

            if ($stmt_responsable->execute()) {
                $stmt_responsable->close();
                
                echo "ID Alumno: $id_alumno, CUI: $cui, Nombre: $nombre, Apellido: $apellido, Fecha Nacimiento: $fecha_nacimiento, Código Responsable: $codigo_responsable, Dirección: $direccion, Departamento: $departamento, Municipio: $municipio";
                // 2. Llamar al procedimiento almacenado para actualizar en tbl_alumnos
                $consulta_alumno = "CALL ActualizarAlumno(?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
                $stmt_alumno = $conn->prepare($consulta_alumno);
                $stmt_alumno->bind_param("issssisii", $id_alumno, $cui, $nombre, $apellido, $fecha_nacimiento, $codigo_responsable, $direccion, $departamento, $municipio);

                if ($stmt_alumno->execute()) {
                    $stmt_alumno->close();
                    
                    // Si todo fue exitoso, confirmar la transacción
                    $conn->commit();
                    echo "Los datos han sido actualizados correctamente.";
                    header('Location: lista_alumnos.php');  // Redirigir a la lista de alumnos después de la actualización
                } else {
                    throw new Exception('Error al actualizar los datos del alumno.');
                }
            } else {
                throw new Exception('Error al actualizar los datos del responsable.');
            }
        } catch (Exception $e) {
            // En caso de error, revertir la transacción
            $conn->rollback();
            echo "Error en la actualización: " . $e->getMessage();
        }
    } else {
        echo "Por favor, rellene todos los campos requeridos.";
    }

    header('Location: registro.php');
?>
