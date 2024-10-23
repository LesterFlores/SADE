<?php

    include('../db_connect.php');
    include '../acciones/mostrar_nombre_usuario.php';
    // Obtener el ID del alumno a actualizar desde el parámetro GET
    $id_ciclo = $_GET['id'];

    $consulta = "
    SELECT 
    ci.codigo_ciclo, 
    ci.codigo_grado,
    gr.descripcion,
    ci.seccion,
    ci.anio,
    ci.codigo_profesor,
    pr.nombre_profesor 
FROM 
    tbl_ciclo ci
LEFT JOIN 
    tbl_grados gr ON gr.codigo_grado = ci.codigo_grado
LEFT JOIN
    tbl_profesores pr ON pr.codigo_profesor = ci.codigo_profesor
WHERE 
    ci.codigo_ciclo = $id_ciclo
";

// Ejecutar la consulta
$resultado = mysqli_query($conn, $consulta);
$registro = mysqli_fetch_assoc($resultado);

    $consulta_alumno = "SELECT al.id_alumno, al.codigo_alumno, CONCAT(al.nombre_alumno, ', ', al.apellido_alumno) as nombre, TIMESTAMPDIFF(YEAR, al.fecha_nacimiento, CURDATE()) AS edad  FROM  tbl_alumnos al
    JOIN tbl_asignacion_alumno ci ON al.id_alumno = ci.codigo_alumno
    WHERE ci.codigo_ciclo = $id_ciclo";
    $resultado_alumno = mysqli_query($conn, $consulta_alumno);
    



    // Obtener todos los grados para llenar el select
$consulta_grados = "SELECT codigo_grado, descripcion FROM tbl_grados";
$resultado_grados = mysqli_query($conn, $consulta_grados);
   
// Obtener todos los profesores para llenar el select
$consulta_profesores = "SELECT codigo_profesor, CONCAT(nombre_profesor, ', ', apellido_profesor) AS nombre_completo   FROM tbl_profesores";
$resultado_profesores = mysqli_query($conn, $consulta_profesores);

// Generar la tabla
$tabla = "
    <table class='table table-striped table-hover' style='width:100%'>
        <thead>
            <tr>
                <th>No.</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Edad</th>
            </tr>
        </thead>
        <tbody>
";

// Añadir filas a la tabla
while ($row = mysqli_fetch_assoc($resultado_alumno)) {
    $tabla .= "
        <tr>
            <td>{$row['id_alumno']}</td>
            <td>{$row['codigo_alumno']}</td>
            <td>{$row['nombre']}</td>
            <td>{$row['edad']}</td>
        </tr>
    ";
}

$tabla .= "</tbody></table>";
    

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
                    <div>
                    <div class="d-flex align-items-center">
                        <button class="boton-salida bnt" onclick="window.location.href='../Login/index.php';">
                            <img class="imagen btsalir" src="../imagenes/salida.png" alt="Salida">
                        </button>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="area2_scrollable-area">
            <!-- Formulario para alumnos -->
            <div class="form-section">
                <h2 class="textColor">Actualizacion de Ciclo</h2>
                <!---------------------------Aqui  mediante el post se envia el formulario-->
                <form action="ac_actualizar_ciclo.php" method="POST" id="actualizarciclo">
                  <div class="form-row">  
                        <div class="form-group col-md-6">
                            <label for="ciclo">Grado</label>
                            <input type="hidden" name="codigo_ciclo" value="<?php echo $registro['codigo_ciclo']; ?>">
                            <select class="form-control" id="grado" name="grado" required>
                                <option value="">Seleccione un Grado</option>
                                <?php
                                while ($row = mysqli_fetch_assoc($resultado_grados)) {
                                    $selected = ($row['codigo_grado'] == $registro['codigo_grado']) ? 'selected' : '';
                                    echo "<option value='{$row['codigo_grado']}' $selected>{$row['descripcion']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="profesor">Profesor</label>
                            <select class="form-control" id="profesor" name="profesor" required>
                            <?php
                                while ($row = mysqli_fetch_assoc($resultado_profesores)) {
                                    $selected = ($row['codigo_profesor'] == $registro['codigo_profesor']) ? 'selected' : '';
                                    echo "<option value='{$row['codigo_profesor']}' $selected>{$row['nombre_completo']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                    
                        <div class="form-group col-md-6">
                            <label for="anio">Año</label>
                            <input type="number" class="form-control" id="anio" name="anio" value="<?php echo $registro['anio']; ?>" required>
                        </div>
                    

                        <div class="form-group col-md-6">
                            <label for="seccion">Seccion</label>
                            <input type="text" class="form-control" id="seccion" name="seccion" value="<?php echo $registro['seccion']; ?>" required>
                        </div>
                    </div>
                    
                    

                    <!-- Botón para guardar todos los datos -->
                    <div class="text-right">
                        <button type="submit" class="btn-guardar">Guardar todos los Cambios</button>
                    </div>
                    
                    <!-- Divider between forms -->
                    <div class="divider"></div>

                    <div class="table-container">
                        <br>
                        <h2 for="seccion" style="text-align: center;">Alumnos Asignados al Ciclo</h2>
                        <?php echo $tabla; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <!-- Reemplaza la versión "slim" por la versión completa -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>