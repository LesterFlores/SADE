<?php
    include '../acciones/mostrar_nombre_usuario.php';
    include('../db_connect.php');
    $consulta = "SELECT * FROM  tbl_parentezco";
    $resultado = mysqli_query($conn, $consulta);
    $data = array();

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $consulta2 = "SELECT * FROM  tbl_departamentos";
    $resultado2 = mysqli_query($conn, $consulta2);
    $data2 = array();

    if ($resultado2->num_rows > 0) {
        while ($row2 = $resultado2->fetch_assoc()) {
            $data2[] = $row2;
        }
    }

    $year = date("Y"); // Obtener el año actual

    $consulta3 = "
    SELECT 
        ci.codigo_ciclo, 
        CONCAT(g.descripcion, ' - ', ci.seccion, ' - ', ci.anio) AS ciclo_completo
    FROM 
        tbl_ciclo ci
    LEFT JOIN 
        tbl_grados g ON ci.codigo_grado = g.codigo_grado
    WHERE
        ci.anio = $year
";

$resultado3 = mysqli_query($conn, $consulta3);
$data3 = array();

if ($resultado3->num_rows > 0) {
    while ($row3 = $resultado3->fetch_assoc()) {
        $data3[] = $row3;
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
    <div class="sidebar">
        <?php
            if(obtenerRol()===1){
                include('../nav.php');
            }else{
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
                <h2 class="textColor">Agregar Datos del Alumno</h2>
                <!---------------------------Aqui  mediante el post se envia el formulario-->
                <form action="ac_agregar_alumno.php" method="POST" id="ingresarAlumno">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="cui">CUI</label>
                            <input type="text" class="form-control" id="cui" name="cui" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="nombres">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" required>
                        </div>
                    </div>
            
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha-nacimiento">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha-nacimiento" name="fecha-nacimiento" required>
                        </div>
                    </div>

                    <div class="form-row"> 
                        <div class="form-group col-md-6">
                            <label for="departamento">Departamento</label>
                            <select class="form-control" id="departamento" name="departamento" required>
                                <option value="">Seleccione un Departamento</option>
                                <?php foreach ($data2 as $row2): ?>
                                <option value="<?php echo $row2['codigo_departamento']; ?>"><?php echo $row2['nombre_departamento']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="municipio">Municipio</label>
                            <select class="form-control" id="municipio" name="municipio" required>
                                <!-- Los municipios se cargarán aquí dinámicamente -->
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                    
                        <div class="form-group col-md-6">
                            <label for="ciclo">Grado</label>
                            <select class="form-control" id="ciclo" name="ciclo" required>
                                <option value="">Seleccione un Ciclo</option>
                                <?php foreach ($data3 as $row3): ?>
                                    <option value="<?php echo $row3['codigo_ciclo']; ?>"><?php echo $row3['ciclo_completo']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Divider between forms -->
                    <div class="divider"></div>

                    <!-- Formulario para datos del padre/madre -->
                    <h2 class="textColor">Agregar Datos del Encargado</h2>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="dpi">DPI</label>
                            <input type="number" class="form-control" id="dpi" name="dpi" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="nombre-padre">Nombre</label>
                            <input type="text" class="form-control" id="nombre-padre" name="nombre-padre" required>
                        </div>
                        
                    </div>
                    <div class="form-row">
                        
                        <div class="form-group col-md-6">
                            <label for="apellido-padre">Apellido</label>
                            <input type="text" class="form-control" id="apellido-padre" name="apellido-padre" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="telefono">Teléfono</label>
                            <input type="number" class="form-control" id="telefono" name="telefono" required>
                        </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                            <label for="parentesco">Parentesco</label>
                            <select class="form-control" id="parentesco" name="parentesco" required>
                                <option value="">Seleccione un parentesco</option>
                                <?php foreach ($data as $row): ?>
                                    <option value="<?php echo $row['codigo_parentezco']; ?>"><?php echo $row['nombre_parentezco']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                      
                    </div>

                    <!-- Botón para guardar todos los datos -->
                    <div class="text-right">
                        <button type="submit" class="btn-guardar">Guardar todos los datos</button>
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
