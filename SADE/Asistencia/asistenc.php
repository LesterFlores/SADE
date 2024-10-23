<?php   

    include '../acciones/mostrar_nombre_usuario.php';
    include '../db_connect.php'; // Asegúrate de incluir tu conexión a la base de datos

    $alumnos = [];
    $total_paginas = 0;
    // Verificar la página actual antes de usarla en cualquier parte del código
    if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
        $pagina_actual = (int)$_GET['pagina'];
    } else {
        $pagina_actual = 1; // Página por defecto si no se especifica
    }

    // Definir la cantidad de filas por página
    $filas_por_pagina = 10;

    // Calcular el inicio de la consulta para la paginación
    $inicio = ($pagina_actual - 1) * $filas_por_pagina;

    // Manejo de la búsqueda de alumnos
    if (isset($_POST['grado']) && isset($_POST['seccion'])) {
        $grado = $_POST['grado'];
        $seccion = $_POST['seccion'];

         // Obtener el total de filas
         $consulta_total_filas = "SELECT COUNT(*) AS total_filas FROM tbl_alumnos WHERE estado = 1";
         $resultado_total_filas = mysqli_query($conn, $consulta_total_filas);
         $total_filas = mysqli_fetch_assoc($resultado_total_filas)['total_filas'];
 
         // Calcular el número total de páginas
         $total_paginas = ceil($total_filas / $filas_por_pagina);

        // Consulta para obtener los alumnos según el grado y sección seleccionados
        $consulta = "
            SELECT DISTINCT
                al.id_alumno, 
                al.codigo_alumno, 
                al.nombre_alumno, 
                al.apellido_alumno, 
                TIMESTAMPDIFF(YEAR, al.fecha_nacimiento, CURDATE()) AS edad, 
                nt.promedio, 
                g.descripcion AS grado, 
                ci.seccion 
            FROM 
                tbl_alumnos al
            JOIN 
                tbl_asignacion_alumno asi ON al.id_alumno = asi.codigo_alumno
            JOIN 
                tbl_ciclo ci ON asi.codigo_ciclo = ci.codigo_ciclo
            JOIN 
                tbl_grados g ON ci.codigo_grado = g.codigo_grado
            LEFT JOIN 
                tbl_nota_total nt ON ci.codigo_ciclo = nt.codigo_ciclo
            WHERE 
                ci.codigo_grado = '$grado' AND ci.seccion = '$seccion'
            GROUP BY
                al.id_alumno
            LIMIT $inicio, $filas_por_pagina
        ";

        $resultado = mysqli_query($conn, $consulta);
        
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $alumnos[] = $row; // Almacenar los resultados en el array
            }
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

    .ubicar{
        margin-top: -15px;
    }

    .atimg1 {
  margin-top: -25px;
  }

</style>

<body>
<?php
    if(obtenerRol()===1){
        include('../nav.php');
    }else{
        include('../menu.php');
    }    
?>
    <div class="content container-fluid">
        <div class="area">
            <fieldset class="complementArea">
                <div class="contenedor">
                    <div class="d-flex align-items-center">
                        <img class="imagen atimg1" src="../imagenes/usuario.png" alt="Usuario">
                        <label class="txalig ubicar" for=""><?php echo obtenerNombreUsuario(); ?></label>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="boton-salida bnt" onclick="window.location.href='../Login/index.php';">
                            <img class="imagen btsalir ubicar1" src="../imagenes/salida.png" alt="Salida">
                        </button>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="area2">
            <br>
            <h1 class="tit">Asistencia Alumnos</h1>
            
            <form method="POST" action="">
                <div class="contenedor">
                    <div class="form-group col-md-6">
                        <select class="form-control" id="grado" name="grado" required>
                            <option value="">Seleccione un Grado</option>
                            <option value="1">Primero</option>
                            <option value="2">Segundo</option>
                            <option value="3">Tercero</option>
                            <option value="4">Cuarto</option>
                            <option value="5">Quinto</option>
                            <option value="6">Sexto</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <select class="form-control" id="seccion" name="seccion" required>
                            <option value="">Seleccionar Sección</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </div>
                </div>

                <div class="contenedor">
                    <button type="submit" class="btn-buscar">Buscar</button>
                    <!-- Botón adicional de Registro -->
                    <button type="button" class="btn btn-primary" onclick="window.location.href='registroAsistencia.php';">Registro</button>
                </div>
            </form>

            <div class="table-container">
            <form method="POST" action="guardar_asistencia.php">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No.</th>
                <th>CUI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Edad</th>
                <th>Grado</th>
                <th>Sección</th>
                <th>Asistencia</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($alumnos as $index => $alumno) {
            echo '<tr>';
            echo '<td>' . ($index + 1) . '</td>';
            echo '<td>' . htmlspecialchars($alumno['codigo_alumno']) . '</td>';
            echo '<td>' . htmlspecialchars($alumno['nombre_alumno']) . '</td>';
            echo '<td>' . htmlspecialchars($alumno['apellido_alumno']) . '</td>';
            echo '<td>' . htmlspecialchars($alumno['edad']) . '</td>';
            echo '<td>' . htmlspecialchars($alumno['grado']) . '</td>';
            echo '<td>' . htmlspecialchars($alumno['seccion']) . '</td>';
            echo '<td>';
             // Campo oculto para enviar 0 si no está marcado
            echo '<input type="hidden" name="asistencia[' . $alumno['id_alumno'] . ']" value="0">';
            // Checkbox para marcar la asistencia
            echo '<input type="checkbox" class="checkbox-opcion" name="asistencia[' . $alumno['id_alumno'] . ']" value="1">';
            echo '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    <!-- Mostrar enlaces de paginación -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if ($pagina_actual > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?php echo $pagina_actual - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                <li class="page-item <?php if ($i == $pagina_actual) echo 'active'; ?>">
                    <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>

            <?php if ($pagina_actual < $total_paginas) { ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?php echo $pagina_actual + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
        <div class="text-right">
            <button type="submit" class="btn btn-primary">Guardar Asistencia</button>
        </div>

        <?php
        if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'guardado') {
            echo '<div class="alert alert-success">Asistencia guardada con éxito.</div>';
        }
        ?>
    
</form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
