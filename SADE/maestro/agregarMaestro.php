<?php

    include('../db_connect.php');
    include '../acciones/mostrar_nombre_usuario.php';
    $consulta2 = "SELECT * FROM  tbl_departamentos";
    $resultado2 = mysqli_query($conn, $consulta2);
    $data2 = array();

    if ($resultado2->num_rows > 0) {
        while ($row2 = $resultado2->fetch_assoc()) {
            $data2[] = $row2;
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
                <h2 class="textColor">Agregar Datos del Maestro</h2>
                <form action="ac_agregar_maestro.php" method="POST" id="ingresarMaestro">
                    <div class="form-row">
                        
                        <div class="form-group col-md-6">
                            <label for="dpi">DPI</label>
                            <input type="text" class="form-control" id="cui" name="cui" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="codigo">Nombres</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cui">Apellidos</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                    </div>
                   
                    <div class="divider"></div>

                    <!-- Formulario para datos del padre/madre sin encapsulamiento -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombre-padre">Telefono</label>
                            <input type="number" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="apellido-padre">Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="nacimiento" name="nacimiento" required>
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
                            <label for="apellido-padre">Direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../alumno/script.js"></script>
</body>

</html>
