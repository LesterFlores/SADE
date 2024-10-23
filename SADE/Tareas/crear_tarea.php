<?php
include('../db_connect.php');
include '../acciones/mostrar_nombre_usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_tarea = $_POST['nombre_tarea'];
    $descripcion = $_POST['descripcion'];
    $codigo_ciclo = $_POST['codigo_ciclo'];
    $codigo_materia = $_POST['codigo_materia'];

    $query = "
        INSERT INTO tbl_tareas (nombre_tarea, descripcion, codigo_ciclo, codigo_materia)
        VALUES ('$nombre_tarea', '$descripcion', '$codigo_ciclo', '$codigo_materia')
    ";
    
    if (mysqli_query($conn, $query)) {
        echo "Tarea creada con éxito.";
    } else {
        echo "Error al crear la tarea: " . mysqli_error($conn);
    }
}

// Obtener ciclos y materias para los selects
$ciclos = mysqli_query($conn, "SELECT 
        ci.codigo_ciclo, 
        CONCAT(g.descripcion, ' - Sección ', ci.seccion, ' - ', ci.anio) AS ciclo 
    FROM 
        tbl_ciclo ci
    JOIN 
        tbl_grados g ON ci.codigo_grado = g.codigo_grado
    WHERE
        ci.estado = 1");
$materias = mysqli_query($conn, "SELECT codigo_materia, nombre_materia FROM tbl_materias");
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
            <!-- Formulario para alumnos -->
            <div class="form-section">
                <h2 class="textColor">Crear Tareas</h2>
                <form id="formulario-datos" action="ac_agregar_tarea.php" method="POST">
                    
                        <div class="form-group col-md-6">
                            <label for="tarea">Nombre de Tarea</label>
                            <input type="text" class="form-control" id="tarea" name="tarea" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="descripcion">Descricion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="descripcion">Punteo</label>
                            <input type="number" class="form-control" id="punteo" name="punteo" required>
                        </div>
                  

                    <div class="form-group col-md-6">
                            <label for="codigo_ciclo">Grado</label>
                            <select class="form-control" id="codigo_ciclo" name="codigo_ciclo" required>
                                <option value="">Seleccione un Grado</option>
                                <?php while ($row = mysqli_fetch_assoc($ciclos)) { ?>
                                    <option value="<?php echo $row['codigo_ciclo']; ?>"><?php echo $row['ciclo']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                        <label for="codigo_materia">Materia</label>
                            <select class="form-control" id="codigo_materia" name="codigo_materia" required>
                                <option value="">Seleccione una Materia</option>
                                <!-- Las materias se cargarán aquí mediante AJAX -->
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="unidad">Unidad</label>
                            <input type="text" class="form-control" id="unidad" name="unidad" required>
                        </div>
                   
                    <div class="divider"></div>


                    <!-- Botón para guardar todos los datos -->
                    <div class="text-right">
                        <button type="submit" class="btn-guardar">Guardar datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="obtener_materias.js"></script>

</body>

</html>
