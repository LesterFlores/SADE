<?php
include('../db_connect.php');

if (isset($_POST['id_alumno'])) {
    $id_alumno = $_POST['id_alumno'];
    $year = date("Y");

    // Consulta para obtener el ciclo más alto asignado al alumno
    $consulta = "
    SELECT 
        ci.codigo_ciclo,
        CONCAT(g.descripcion, ' - ', ci.seccion, ' - ', ci.anio) AS ciclo_completo,
        aa.Estado
    FROM 
        tbl_asignacion_alumno aa
    JOIN 
        tbl_ciclo ci ON aa.codigo_ciclo = ci.codigo_ciclo
    JOIN 
        tbl_grados g ON ci.codigo_grado = g.codigo_grado
    WHERE 
        aa.codigo_alumno = $id_alumno
    ORDER BY ci.codigo_grado DESC
    LIMIT 1";

    $resultado = mysqli_query($conn, $consulta);

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $estado = $row['Estado'];

        if ($estado === 'promovido') {
            // Si el alumno fue promovido, buscar el siguiente ciclo
            $consulta_siguiente = "
            SELECT 
                ci.codigo_ciclo, 
                CONCAT(g.descripcion, ' - ', ci.seccion, ' - ', ci.anio) AS ciclo_completo
            FROM 
                tbl_ciclo ci
            JOIN 
                tbl_grados g ON ci.codigo_grado = g.codigo_grado
            WHERE 
                ci.codigo_grado = (SELECT codigo_grado + 1 FROM tbl_ciclo WHERE codigo_ciclo = {$row['codigo_ciclo']})
            AND ci.anio = $year
            LIMIT 1";
            $resultado_siguiente = mysqli_query($conn, $consulta_siguiente);

            if ($resultado_siguiente->num_rows > 0) {
                $row_siguiente = $resultado_siguiente->fetch_assoc();
                echo "<option value='{$row_siguiente['codigo_ciclo']}'>{$row_siguiente['ciclo_completo']}</option>";
            } else {
                echo "<option value=''>No hay ciclo siguiente disponible</option>";
            }
        } else {
            // Si el alumno no fue promovido, mostrar el ciclo actual
            echo "<option value='{$row['codigo_ciclo']}'>{$row['ciclo_completo']}</option>";
        }
    } else {
        echo "<option value=''>No se encontraron ciclos</option>";
    }
}
?>
