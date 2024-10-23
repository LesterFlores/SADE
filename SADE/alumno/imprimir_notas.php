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
    $query = "SELECT m.nombre_materia, nt.zona_total
              FROM tbl_nota_total nt
              JOIN tbl_materias m ON nt.codigo_materia = m.codigo_materia
              WHERE nt.codigo_alumno = $id_alumno";
    $resultado = $conn->query($query);

    // Variables para calcular el promedio
    $total_zona = 0;
    $cantidad_materias = 0;

    // Verificar si hay datos
    if ($resultado->num_rows > 0) {
        // Centrando la tabla
        $pdf->Cell(40); // Esto añade un margen izquierdo para centrar la tabla
        
        // Cabecera de la tabla
        $pdf->Cell(80, 10, 'Materia', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Zona Total', 1, 1, 'C');

        // Imprimir cada fila
        while ($row = $resultado->fetch_assoc()) {
            $pdf->Cell(40); // Margen izquierdo para centrar la tabla
            $pdf->Cell(80, 10, utf8_decode($row['nombre_materia']), 1, 0, 'C');
            // Establecer el color según la nota
            if ($row['zona_total'] < 60) {
                $pdf->SetTextColor(255, 0, 0); // Rojo
            } else {
                $pdf->SetTextColor(0, 0, 0); // Negro
            }
            $pdf->Cell(40, 10, $row['zona_total'], 1, 1, 'C');

            // Restablecer el color del texto a negro para el siguiente ciclo
            $pdf->SetTextColor(0, 0, 0);

            // Calcular el total de las zonas y la cantidad de materias
            $total_zona += $row['zona_total'];
            $cantidad_materias++;
        }

        // Calcular el promedio
        $promedio = $cantidad_materias > 0 ? $total_zona / $cantidad_materias : 0;

        // Agregar fila con el promedio
        $pdf->Ln(5); // Espacio antes del promedio
        $pdf->Cell(40); // Margen izquierdo para centrar la tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(80, 10, 'Promedio', 1, 0, 'C');
        $pdf->Cell(40, 10, number_format($promedio, 2), 1, 1, 'C');
    } else {
        // Si no hay notas, mostrar un mensaje
        $pdf->Cell(0, 10, 'No se encontraron notas para este alumno.', 0, 1, 'C');
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

    // Crear el nombre del archivo
    $nombre_archivo = "Notas_" . str_replace(' ', '_', $nombre_completo) . ".pdf"; // Reemplaza espacios con guiones bajos

    // Enviar el PDF al navegador
    $pdf->Output('D', $nombre_archivo); // 'D' indica que se descargará el archivo
} else {
    // Si no se envió el id_alumno, mostrar un mensaje de error
    echo "Error: No se ha proporcionado el ID del alumno.";
}
?>