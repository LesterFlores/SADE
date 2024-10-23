<?php
// Conexión a la base de datos
include('../db_connect.php');
include '../acciones/mostrar_nombre_usuario.php';

// Obtener el ID del alumno a actualizar desde el parámetro GET
$id_maestro = $_GET['id'];

// Consulta para obtener los datos del alumno y el responsable
$consulta = "
    SELECT 
    pr.codigo_profesor,  
    pr.nombre_profesor, 
    pr.apellido_profesor,
    pr.telefono_profesor, 
    pr.fecha_nacimiento, 
    pr.direccion, 
    pr.codigo_departamento, 
    dep.nombre_departamento,
    pr.codigo_municipio, 
    mun.nombre_municipio
FROM 
    tbl_profesores pr
LEFT JOIN
    tbl_departamentos dep ON dep.codigo_departamento = pr.codigo_departamento
LEFT JOIN
    tbl_municipios mun ON mun.codigo_municipio = pr.codigo_municipio
WHERE 
    pr.codigo_profesor = $id_maestro
";

// Ejecutar la consulta
$resultado = mysqli_query($conn, $consulta);
$maestro = mysqli_fetch_assoc($resultado);

// Obtener todos los departamentos para llenar el select
$consulta_departamentos = "SELECT codigo_departamento, nombre_departamento FROM tbl_departamentos";
$resultado_departamentos = mysqli_query($conn, $consulta_departamentos);

// Obtener todos los municipios relacionados al departamento seleccionado
$consulta_municipios = "SELECT codigo_municipio, nombre_municipio FROM tbl_municipios WHERE codigo_departamento = {$maestro['codigo_departamento']}";
$resultado_municipios = mysqli_query($conn, $consulta_municipios);

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

        <div class="area2 scrollable-area">
            <!-- Formulario para alumnos -->
            <div class="form-section">
                <h2 class="textColor">Ver Datos del Maestro</h2>
                <form action="ac_actualizar_maestro.php" method="POST" id="formulario-datos">
                    <div class="form-row">
            
                        <div class="form-group col-md-6">
                            <label for="dpi">DPI</label>
                            <input type="text" class="form-control" id="cui" name="cui" value="<?php echo $maestro['codigo_profesor']; ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="codigo">Nombres</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $maestro['nombre_profesor']; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cui">Apellidos</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $maestro['apellido_profesor']; ?>" required>
                        </div>
                    </div>
                   
                    <div class="divider"></div>

                    <!-- Formulario para datos del padre/madre sin encapsulamiento -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombre-padre">Telefono</label>
                            <input type="number" class="form-control" id="telefono" name="telefono" value="<?php echo $maestro['telefono_profesor']; ?>"required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="apellido-padre">Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="nacimiento" name="nacimiento" value="<?php echo $maestro['fecha_nacimiento']; ?>"required>
                        </div>
                    </div>
                    <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="departamento">Departamento</label>
                    <select class="form-control" id="departamento" name="departamento" required>
                        <option value="">Seleccione un departamento</option>
                        <?php
                        while ($row = mysqli_fetch_assoc($resultado_departamentos)) {
                            $selected = ($row['codigo_departamento'] == $maestro['codigo_departamento']) ? 'selected' : '';
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
                            $selected = ($row['codigo_municipio'] == $maestro['codigo_municipio']) ? 'selected' : '';
                            echo "<option value='{$row['codigo_municipio']}' $selected>{$row['nombre_municipio']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="apellido-padre">Direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $maestro['direccion']; ?>" required>
                        </div>
                    </div>

                    <!-- Botón para guardar todos los datos -->
                    <div class="text-right">
                        <button type="submit" class="btn-guardar">Guardar todos los Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
