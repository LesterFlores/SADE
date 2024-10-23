<?php

include('../db_connect.php');
include '../acciones/mostrar_nombre_usuario.php';

$year = date("Y"); // Obtener el año actual

// Obtener alumnos que aún no están asignados a ningún ciclo o cuyo ciclo anterior está inactivo
$consulta = "
SELECT 
    al.id_alumno, 
    CONCAT(al.nombre_alumno, ', ', al.apellido_alumno) AS nombre
FROM 
    tbl_alumnos al
LEFT JOIN 
    tbl_asignacion_alumno aa ON al.id_alumno = aa.codigo_alumno
LEFT JOIN 
    tbl_ciclo ci ON aa.codigo_ciclo = ci.codigo_ciclo
WHERE 
    aa.codigo_alumno IS NULL 
    OR (ci.estado = 0)
";
$resultado = mysqli_query($conn, $consulta);
$data = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $data[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SADE</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@200..900&display=swap" rel="stylesheet">
    <!-- FontAwesome CSS for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<style>
    .textColor {
        color: #007bff;
    }

    .ubicar {
        margin-top: -15px;
    }

    .atimg1 {
        margin-top: -25px;
    }
</style>

<body>
    <div class="sidebar">
        <?php
        if (obtenerRol() === 1) {
            include('../nav.php');
        } else {
            include('../menu.php');
        }
        ?>
    </div>

    <div class="content container-fluid">
        <div class="area">
            <fieldset class="complementArea">
                <div class="contenedor">
                    <div class="d-flex align-items-center">
                        <img class="imagen atimg1" src="../imagenes/usuario.png" alt="Usuario">
                        <label class="txalig ubicar" for=""><?php echo obtenerNombreUsuario(); ?></label>
                    <div>
                    <div class="d-flex align-items-center">
                        <button class="boton-salida bnt" onclick="window.location.href='../Login/index.php';">
                            <img class="imagen btsalir" src="../imagenes/salida.png" alt="Salida">
                        </button>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="area2 scrollable-area">
            <!-- Formulario para alumnos -->
            <div class="form-section">
                <h2 class="textColor">Asignación de Alumnos</h2>
                <form action="ac_asignar_alumnos.php" method="POST" id="asignarAlumno">
                    <div class="form-row"> 
                        <div class="form-group col-md-6">
                            <label for="alumno">Alumno</label>
                            <select class="form-control" id="alumno" name="alumno" required onchange="cargarCiclo(this.value)">
                                <option value="">Seleccione un Alumno</option>
                                <?php foreach ($data as $row): ?>
                                <option value="<?php echo $row['id_alumno']; ?>"><?php echo $row['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="ciclo">Grado</label>
                            <select class="form-control" id="ciclo" name="ciclo" required>
                                <option value="">Seleccione un Ciclo</option>
                                <!-- Aquí se cargará el ciclo correspondiente vía AJAX -->
                            </select>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn-guardar">Guardar todos los datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Cargar los ciclos del alumno seleccionado con AJAX -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function cargarCiclo(id_alumno) {
            $.ajax({
                url: 'cargar_ciclo.php',
                method: 'POST',
                data: { id_alumno: id_alumno },
                success: function(data) {
                    $('#ciclo').html(data); // Llenar el select con los ciclos
                }
            });
        }
    </script>
</body>

</html>
