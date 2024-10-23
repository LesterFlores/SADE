<?php
include('../db_connect.php');

if (isset($_POST['codigo_departamento'])) {
    $codigo_departamento = $_POST['codigo_departamento'];

    $consulta = "SELECT * FROM tbl_municipios WHERE codigo_departamento = ?";
    $stmt = $conn->prepare($consulta);
    $stmt->bind_param('i', $codigo_departamento);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        while ($row4 = $resultado->fetch_assoc()) {
            echo '<option value="' . $row4['codigo_municipio'] . '">' . $row4['nombre_municipio'] . '</option>';
        }
    } else {
        echo '<option value="">No se encontraron municipios</option>';
    }

    $stmt->close();
    $conn->close();
} else {
    echo '<option value="">Error: Código de departamento no proporcionado</option>';
}
?>
