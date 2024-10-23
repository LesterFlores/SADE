<?php
// Conexión a la base de datos
include('../db_connect.php');
include '../acciones/mostrar_nombre_usuario.php';

// Obtener el ID del alumno a actualizar desde el parámetro GET
$id_alumno = $_GET['id'];

// Consulta para obtener los datos del alumno y el responsable
$consulta = "
    SELECT 
    al.id_alumno, 
    al.codigo_alumno, 
    al.nombre_alumno, 
    al.apellido_alumno, 
    al.fecha_nacimiento, 
    al.direccion, 
    al.codigo_departamento, 
    dep.nombre_departamento,
    al.codigo_municipio, 
    mun.nombre_municipio,
    al.codigo_responsable,
    res.dpi_responsable, 
    res.nombre_responsable, 
    res.apellido_responsable, 
    res.telefono, 
    res.codigo_parentezco,
    par.nombre_parentezco
FROM 
    tbl_alumnos al
LEFT JOIN 
    tbl_responsables res ON res.codigo_responsable = al.codigo_responsable
LEFT JOIN
    tbl_parentezco par ON par.codigo_parentezco = res.codigo_parentezco
LEFT JOIN
    tbl_departamentos dep ON dep.codigo_departamento = al.codigo_departamento
LEFT JOIN
    tbl_municipios mun ON mun.codigo_municipio = al.codigo_municipio
WHERE 
    al.id_alumno = $id_alumno
";

// Ejecutar la consulta
$resultado = mysqli_query($conn, $consulta);
$alumno = mysqli_fetch_assoc($resultado);

// Obtener todos los departamentos para llenar el select
$consulta_departamentos = "SELECT codigo_departamento, nombre_departamento FROM tbl_departamentos";
$resultado_departamentos = mysqli_query($conn, $consulta_departamentos);

// Obtener todos los municipios relacionados al departamento seleccionado
$consulta_municipios = "SELECT codigo_municipio, nombre_municipio FROM tbl_municipios WHERE codigo_departamento = {$alumno['codigo_departamento']}";
$resultado_municipios = mysqli_query($conn, $consulta_municipios);

// Obtener todos los departamentos para llenar el select
$consulta_parentezco = "SELECT codigo_parentezco, nombre_parentezco FROM tbl_parentezco";
$resultado_parentezco = mysqli_query($conn, $consulta_parentezco);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Alumno - SADE</title>
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
            <!-- Formulario para actualizar alumno -->
            <div class="form-section">
                <h2 class="textColor">Actualizar Datos del Alumno</h2>
                <form action="ac_actualizar_alumno.php" method="POST" id="actualizarAlumno">
                    <!-- Input hidden para el id del alumno -->
                    <input type="hidden" name="id_alumno" value="<?php echo $alumno['id_alumno']; ?>">
                    <input type="hidden" name="id_responsable" value="<?php echo $alumno['codigo_responsable']; ?>">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="cui">CUI</label>
                            <input type="text" class="form-control" id="cui" name="cui" value="<?php echo $alumno['codigo_alumno']; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombres">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $alumno['nombre_alumno']; ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $alumno['apellido_alumno']; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $alumno['fecha_nacimiento']; ?>" required>
                        </div>
                    </div>

                    <!-- Select de Departamento -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="departamento">Departamento</label>
                    <select class="form-control" id="departamento" name="departamento" required>
                        <option value="">Seleccione un departamento</option>
                        <?php
                        while ($row = mysqli_fetch_assoc($resultado_departamentos)) {
                            $selected = ($row['codigo_departamento'] == $alumno['codigo_departamento']) ? 'selected' : '';
                            echo "<option value='{$row['codigo_departamento']}' $selected>{$row['nombre_departamento']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Select de Municipio -->
                <div class="form-group col-md-6">
                    <label for="municipio">Municipio</label>
                    <select class="form-control" id="municipio" name="municipio" required>
                        <option value="">Seleccione un municipio</option>
                        <?php
                        while ($row = mysqli_fetch_assoc($resultado_municipios)) {
                            $selected = ($row['codigo_municipio'] == $alumno['codigo_municipio']) ? 'selected' : '';
                            echo "<option value='{$row['codigo_municipio']}' $selected>{$row['nombre_municipio']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $alumno['direccion']; ?>" required>
                        </div>
                    </div>

                    <!-- Divider between forms -->
                    <div class="divider"></div>

                    <!-- Formulario para actualizar datos del responsable -->
                    <h2 class="textColor">Actualizar Datos del Encargado</h2>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="dpi">DPI</label>
                            <input type="number" class="form-control" id="dpi" name="dpi" value="<?php echo $alumno['dpi_responsable']; ?>" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="nombre-padre">Nombre</label>
                            <input type="text" class="form-control" id="nombre-padre" name="nombre-padre" value="<?php echo $alumno['nombre_responsable']; ?>" required>
                        </div>
                        
                    </div>
                    
                    <div class="form-row">
                        
                        <div class="form-group col-md-6">
                            <label for="apellido-padre">Apellido</label>
                            <input type="text" class="form-control" id="apellido-padre" name="apellido-padre" value="<?php echo $alumno['apellido_responsable']; ?>" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="telefono">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo $alumno['telefono']; ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="parentesco">Parentesco</label>
                            <select class="form-control" id="parentesco" name="parentesco" required>
                                <option value="">Seleccione un parentesco</option>
                                <?php
                                while ($row = mysqli_fetch_assoc($resultado_parentezco)) {
                                    $selected = ($row['codigo_parentezco'] == $alumno['codigo_parentezco']) ? 'selected' : '';
                                    echo "<option value='{$row['codigo_parentezco']}' $selected>{$row['nombre_parentezco']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">Actualizar Datos</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
