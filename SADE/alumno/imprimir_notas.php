<?php
// Incluir la biblioteca FPDF
require('../vendor/setasign/fpdf/fpdf.php');

// Crear una conexión a la base de datos
require('../db_connect.php');

// Verificar si el id_alumno ha sido enviado por GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Obtener el ID del alumno desde el método GET
    $id_alumno = $_GET['id'];

    // Crear una instancia de FPDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Configurar la fuente para el título del documento
    $pdf->SetFont('Arial', 'B', 16);

    // Obtener el nombre completo del alumno
    $query_alumno = "SELECT CONCAT(nombre_alumno, ' ', apellido_alumno) AS nombre_completo FROM tbl_alumnos WHERE id_alumno = $id_alumno";
    $resultado_alumno = $conn->query($query_alumno);
    
    if ($resultado_alumno->num_rows > 0) {
        $alumno = $resultado_alumno->fetch_assoc();
        $nombre_completo = utf8_decode($alumno['nombre_completo']); // Decodificar para caracteres especiales
    } else {
        $nombre_completo = "Alumno no encontrado";
    }

    // Título del documento
    $pdf->Cell(0, 10, 'Informe de Notas por Materia', 0, 1, 'C');
    $pdf->Ln(5); // Espacio
    
    // Subtítulo con el nombre completo del alumno
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Alumno: $nombre_completo", 0, 1, 'C');
    $pdf->Ln(10);  // Espacio

    // Configurar la fuente para el contenido
    $pdf->SetFont('Arial', '', 12);

    // Obtener las materias y notas del alumno
    $query = "SELECT m.nombre_materia, 
                     MAX(CASE WHEN nt.unidad = 1 THEN nt.zona_total END) AS nota_unidad_1,
                     MAX(CASE WHEN nt.unidad = 2 THEN nt.zona_total END) AS nota_unidad_2,
                     MAX(CASE WHEN nt.unidad = 3 THEN nt.zona_total END) AS nota_unidad_3,
                     MAX(CASE WHEN nt.unidad = 4 THEN nt.zona_total END) AS nota_unidad_4
              FROM tbl_nota_total nt
              JOIN tbl_materias m ON nt.codigo_materia = m.codigo_materia
              WHERE nt.codigo_alumno = $id_alumno
              GROUP BY m.nombre_materia";
    $resultado = $conn->query($query);

    // Variables para calcular el promedio
    $total_zona_1 = 0;
    $total_zona_2 = 0;
    $total_zona_3 = 0;
    $total_zona_4 = 0;
    $cantidad_materias = 0;

    // Verificar si hay datos
    if ($resultado->num_rows > 0) {
        // Centrando la tabla
        $pdf->Cell(5); // Esto añade un margen izquierdo para centrar la tabla
        
        // Cabecera de la tabla
        $pdf->Cell(60, 10, 'Materia', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Unidad 1', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Unidad 2', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Unidad 3', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Unidad 4', 1, 1, 'C');

        // Imprimir cada fila
        while ($row = $resultado->fetch_assoc()) {
            $pdf->Cell(5); // Margen izquierdo para centrar la tabla
            $pdf->Cell(60, 10, utf8_decode($row['nombre_materia']), 1, 0, 'C');

            // Establecer el color según la nota de Unidad 1
            $pdf->SetTextColor($row['nota_unidad_1'] < 60 ? 255 : 0, $row['nota_unidad_1'] < 60 ? 0 : 0, 0);
            $pdf->Cell(30, 10, $row['nota_unidad_1'] ?? 'N/A', 1, 0, 'C');

            // Restablecer el color del texto a negro para el siguiente ciclo
            $pdf->SetTextColor(0, 0, 0);

            // Establecer el color según la nota de Unidad 2
            $pdf->SetTextColor($row['nota_unidad_2'] < 60 ? 255 : 0, $row['nota_unidad_2'] < 60 ? 0 : 0, 0);
            $pdf->Cell(30, 10, $row['nota_unidad_2'] ?? 'N/A', 1, 0, 'C');

            // Restablecer el color del texto a negro
            $pdf->SetTextColor(0, 0, 0);

            // Establecer el color según la nota de Unidad 3
            $pdf->SetTextColor($row['nota_unidad_3'] < 60 ? 255 : 0, $row['nota_unidad_3'] < 60 ? 0 : 0, 0);
            $pdf->Cell(30, 10, $row['nota_unidad_3'] ?? 'N/A', 1, 0, 'C');

            // Restablecer el color del texto a negro
            $pdf->SetTextColor(0, 0, 0);

            // Establecer el color según la nota de Unidad 4
            $pdf->SetTextColor($row['nota_unidad_4'] < 60 ? 255 : 0, $row['nota_unidad_4'] < 60 ? 0 : 0, 0);
            $pdf->Cell(30, 10, $row['nota_unidad_4'] ?? 'N/A', 1, 1, 'C');

            // Restablecer el color del texto a negro para el siguiente ciclo
            $pdf->SetTextColor(0, 0, 0);

            // Calcular el total de las zonas y la cantidad de materias
            if ($row['nota_unidad_1'] !== null) {
                $total_zona_1 += $row['nota_unidad_1'];
            }
            if ($row['nota_unidad_2'] !== null) {
                $total_zona_2 += $row['nota_unidad_2'];
            }
            if ($row['nota_unidad_3'] !== null) {
                $total_zona_3 += $row['nota_unidad_3'];
            }
            if ($row['nota_unidad_4'] !== null) {
                $total_zona_4 += $row['nota_unidad_4'];
            }
            $cantidad_materias++;
        }

        // Calcular los promedios
        $promedio_1 = $cantidad_materias > 0 ? $total_zona_1 / $cantidad_materias : 0;
        $promedio_2 = $cantidad_materias > 0 ? $total_zona_2 / $cantidad_materias : 0;
        $promedio_3 = $cantidad_materias > 0 ? $total_zona_3 / $cantidad_materias : 0;
        $promedio_4 = $cantidad_materias > 0 ? $total_zona_4 / $cantidad_materias : 0;

        // Agregar fila con el promedio
        $pdf->Ln(5); // Espacio antes del promedio
        $pdf->Cell(5); // Margen izquierdo para centrar la tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'Promedio', 1, 0, 'C');
        $pdf->Cell(30, 10, number_format($promedio_1, 2), 1, 0, 'C');
        $pdf->Cell(30, 10, number_format($promedio_2, 2), 1, 0, 'C');
        $pdf->Cell(30, 10, number_format($promedio_3, 2), 1, 0, 'C');
        $pdf->Cell(30, 10, number_format($promedio_4, 2), 1, 1, 'C');
    } else {
        // Si no hay notas, mostrar un mensaje
        $pdf->Cell(0, 10, 'No se encontraron notas para este alumno.', 0, 1, 'C');
    }

    // Cerrar la conexión
    $conn->close();

    // Salvar el documento PDF
    $pdf->Output();
} else {
    echo "ID de alumno no proporcionado.";
}
?>

