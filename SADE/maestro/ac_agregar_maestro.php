<?php

    $cui = !empty($_POST['cui']) ? $_POST['cui'] : '';
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellido = !empty($_POST['apellido']) ? $_POST['apellido'] : '';
    $telefono = !empty($_POST['telefono']) ? $_POST['telefono'] : '';
    $fecha_nacimiento = !empty($_POST['nacimiento']) ? $_POST['nacimiento'] : '';
    $direccion = !empty($_POST['direccion']) ? $_POST['direccion'] : '';
    $departamento = !empty($_POST['departamento']) ? $_POST['departamento'] : '';
    $municipio = !empty($_POST['municipio']) ? $_POST['municipio'] : '';

    echo "Fecha de nacimiento recibida: '" . $fecha_nacimiento . "'<br>";
   

    if ($nombre && $apellido && $cui && $fecha_nacimiento && $direccion && $telefono && $departamento && $municipio) {
        include('../db_connect.php');
        
        // Iniciar una transacción
        $conn->begin_transaction();

        try {
                // 2. Llamar al procedimiento almacenado para insertar en tbl_alumnos
                echo "fecha segue siendo: '". $fecha_nacimiento . "' <br>";
                $consulta_maestro = "CALL InsertarMaestros(?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt_maestro = $conn->prepare($consulta_maestro);
                $stmt_maestro->bind_param("ssssssii", $cui, $nombre, $apellido, $telefono, $fecha_nacimiento, $direccion, $departamento, $municipio);
                echo "fecha segue siendo: '". $fecha_nacimiento . "' <br>";
                if ($stmt_maestro->execute()) {
                    echo 'Registro guardado correctamente';
                    $stmt_maestro->close();
                } else {
                    throw new Exception('Error al Guardar Alumno: ' . $stmt_maestro->error);
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
        // Imprimir los valores para depuración
        echo "Nombre: '$nombre'<br>";
        echo "Apellido: '$apellido'<br>";
        echo "CUI: '$cui'<br>";
        echo "Fecha de nacimiento: '$fecha_nacimiento_mysql'<br>";
        echo "Dirección: '$direccion'<br>";
        echo "Teléfono: '$telefono'<br>";
        echo "Departamento: '$departamento'<br>";
        echo "Municipio: '$municipio'<br>";
    }

    header('Location: Maestros.php')
?>
