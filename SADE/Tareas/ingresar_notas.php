<?php
include('../db_connect.php');
include '../acciones/mostrar_nombre_usuario.php';
$id_tarea = !empty($_GET['id_tarea']) ? $_GET['id_tarea'] : '';

$query_tarea = "SELECT codigo_ciclo, nombre_tarea, punteo FROM tbl_tareas WHERE id_tarea = '$id_tarea'";
$result_tarea = mysqli_query($conn, $query_tarea);
$row_tarea = mysqli_fetch_assoc($result_tarea);
$codigo_ciclo = $row_tarea['codigo_ciclo'];
$punteo_maximo = $row_tarea['punteo']; // Obtener el punteo máximo de la tarea
$tarea = $row_tarea['nombre_tarea'];

// Definir la cantidad de filas por página
$filas_por_pagina = 10;

// Verificar la página actual
if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
    $pagina_actual = (int)$_GET['pagina'];
} else {
    $pagina_actual = 1; // Página por defecto
}

// Calcular el inicio de la consulta para la paginación
$inicio = ($pagina_actual - 1) * $filas_por_pagina;

// Obtener el total de filas
$consulta_total_filas = "SELECT COUNT(*) AS total_filas FROM tbl_alumnos WHERE estado = 1";
$resultado_total_filas = mysqli_query($conn, $consulta_total_filas);
$total_filas = mysqli_fetch_assoc($resultado_total_filas)['total_filas'];

// Calcular el número total de páginas
$total_paginas = ceil($total_filas / $filas_por_pagina);

// Ahora consulta los alumnos asignados a ese ciclo
$query_alumnos = "
    SELECT a.id_alumno, CONCAT(a.nombre_alumno, ', ', a.apellido_alumno) AS nombre
    FROM tbl_alumnos a
    JOIN tbl_asignacion_alumno aa ON a.id_alumno = aa.codigo_alumno
    WHERE aa.codigo_ciclo = '$codigo_ciclo'
    LIMIT $inicio, $filas_por_pagina
";

$result_alumnos = mysqli_query($conn, $query_alumnos);

?>

<!DOCTYPE html>
<html lang="es">

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

        <div class="form-section">
    <h2>Ingresar Notas para la Tarea <?php echo $tarea ?></h2>
    <form id="formulario-datos" action="guardar_notas.php" method="POST">
        <input type="hidden" name="id_tarea" value="<?php echo $id_tarea; ?>">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Nota Maxima <?php echo $punteo_maximo ?></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($alumno = mysqli_fetch_assoc($result_alumnos)) { ?>
                    <tr>
                        <td><?php echo $alumno['nombre']; ?></td>
                        <td>
                            <input type="number" name="nota[<?php echo $alumno['id_alumno']; ?>]" min="0" max="<?php echo $punteo_maximo; ?>" class="form-control">
                        </td>
                    </tr>
                <?php } ?>
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
        <button type="submit" class="btn btn-success">Guardar Notas</button>
    </form>
</div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
