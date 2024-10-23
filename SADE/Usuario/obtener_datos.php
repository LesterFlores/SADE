<?php
include('../db_connect.php');

// Definir la cantidad de filas por página
$filas_por_pagina = 3;

// Verificar la página actual
if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
    $pagina_actual = (int)$_GET['pagina'];
} else {
    $pagina_actual = 1; // Página por defecto
}

// Calcular el inicio de la consulta para la paginación
$inicio = ($pagina_actual - 1) * $filas_por_pagina;

// Obtener el total de filas
$consulta_total_filas = "SELECT COUNT(*) AS total_filas FROM tbl_usuarios WHERE estado = 1";
$resultado_total_filas = mysqli_query($conn, $consulta_total_filas);
$total_filas = mysqli_fetch_assoc($resultado_total_filas)['total_filas'];

// Calcular el número total de páginas
$total_paginas = ceil($total_filas / $filas_por_pagina);

// Consultar los usuarios
$sql = "SELECT * FROM tbl_usuarios LIMIT $inicio, $filas_por_pagina";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rowClass = $row['estado'] == 0 ? 'inactive-row' : '';
        // Mostrar asteriscos en lugar de la contraseña
        $password_hidden = str_repeat('*', 10); // Mostrar 10 asteriscos
        echo "<tr class='$rowClass' data-id='{$row['codigo_usuario']}'>
                <td>{$row['codigo_usuario']}</td>
                <td>{$row['nombre_usuario']}</td>
                <td>{$row['correo_electronico']}</td>
                <td>$password_hidden</td>
                <td>" . ($row['estado'] == 1 ? 'Activo' : 'Inactivo') . "</td>
                <td><button class='btn-edit btn btn-primary'>Editar</button></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No se encontraron usuarios.</td></tr>";
}

$conn->close();
?>
