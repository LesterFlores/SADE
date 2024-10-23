<?php

include('../db_connect.php');

$anio = $_POST['anio']; // Obtener el año seleccionado del formulario

// Modificar la consulta SQL para buscar los ciclos del año seleccionado
$consulta = "
    SELECT 
    ci.codigo_ciclo,
    g.descripcion AS grado, 
    ci.seccion, 
    ci.anio,
    ma.nombre_profesor 
FROM 
    tbl_ciclo ci
LEFT JOIN 
    tbl_grados g ON ci.codigo_grado = g.codigo_grado
LEFT JOIN 
    tbl_profesores ma ON ci.codigo_profesor = ma.codigo_profesor
WHERE 
    ci.anio = '$anio'
";

// Ejecutar la consulta
$resultado = mysqli_query($conn, $consulta);

// Generar la tabla
$tabla = "
    <table class='table table-striped table-hover' style='width:100%'>
        <thead>
            <tr>
                <th>Grado</th>
                <th>Seccion</th>
                <th>Año</th>
                <th>Profesor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
";

// Añadir filas a la tabla
while ($registro = mysqli_fetch_assoc($resultado)) {
    $tabla .= "
        <tr>
            <td>{$registro['grado']}</td>
            <td>{$registro['seccion']}</td>
            <td>{$registro['anio']}</td>
            <td>{$registro['nombre_profesor']}</td>
            <td>
                <button class='btn-opcion text-primary'  title='Editar' onclick='window.location.href=\"ver.php?id={$registro['codigo_ciclo']}\"'><i class='fas fa-edit'></i></button> 
                <button class='btn-opcion text-danger'  title='Baja' onclick='window.location.href=\"cambiar_estado.php?id={$registro['codigo_ciclo']}\"'><i class='fas fa-times'></i></button>
            </td>
        </tr>
    ";
}

$tabla .= "</tbody></table>";
                
echo $tabla; // Enviar la tabla generada como respuesta
?>
