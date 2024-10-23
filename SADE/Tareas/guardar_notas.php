<?php
// Incluir archivo de conexión
include('../db_connect.php');

// Verificar si los datos fueron enviados por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el id_tarea del formulario
    $id_tarea = $_POST['id_tarea'];

    // Obtener el arreglo de notas
    $notas = $_POST['nota']; // Formato: ['id_alumno' => 'nota']

    // Iterar sobre el arreglo de notas
    foreach ($notas as $id_alumno => $nota) {

        // Aquí puedes insertar o actualizar las notas en la base de datos
        // Verificar si la nota es válida
        if (is_numeric($nota) && $nota >= 0 && $nota <= 100) {
            // Inserta o actualiza la nota en la base de datos
            $query = "
                INSERT INTO tbl_nota_tarea (id_tarea, id_alumno, punteo)
                VALUES ('$id_tarea', '$id_alumno', '$nota')
                ON DUPLICATE KEY UPDATE punteo = '$nota'
            ";
            mysqli_query($conn, $query);

            $query2 = "
                UPDATE tbl_tareas SET estado = 0 WHERE id_tarea = $id_tarea";
            mysqli_query($conn, $query2);
        } else {
            echo "Nota no válida para el alumno con ID: $id_alumno.<br>";
        }
        
    }

    echo "Proceso completado.";
} else {
    echo "No se recibieron datos.";
}

header('Location: tareas.php')
?>
