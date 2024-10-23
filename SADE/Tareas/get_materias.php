<?php
include('../db_connect.php');

if (isset($_POST['codigo_ciclo'])) {
    $codigo_ciclo = $_POST['codigo_ciclo'];

    $consulta = "SELECT m.codigo_materia, m.nombre_materia 
        FROM tbl_materias m
        JOIN tbl_asignacion_materia am ON am.codigo_materia = m.codigo_materia
        JOIN tbl_ciclo ci ON am.codigo_grado = ci.codigo_grado
        WHERE ci.codigo_ciclo = ?";
    $stmt = $conn->prepare($consulta);
    $stmt->bind_param('i', $codigo_ciclo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        while ($row4 = $resultado->fetch_assoc()) {
            echo '<option value="' . $row4['codigo_materia'] . '">' . $row4['nombre_materia'] . '</option>';
        }
    } else {
        echo '<option value="">No se encontraron materias</option>';
    }

    $stmt->close();
    $conn->close();
} else {
    echo '<option value="">Error: Código de ciclo no proporcionado</option>';
}
?>
