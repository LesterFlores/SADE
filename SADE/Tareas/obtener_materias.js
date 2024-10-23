$(document).ready(function() {
    $('#codigo_ciclo').change(function() {
        var codigo_ciclo = $(this).val();
        console.log('Código Ciclo:', codigo_ciclo);

        // Limpiar el select de municipios
        $('#codigo_materia').html('<option value="">Cargando...</option>');

        // Hacer la solicitud AJAX para obtener los municipios
        $.ajax({
            url: 'get_materias.php', // Ruta del archivo PHP que obtendrá los municipios
            type: 'POST',
            data: { codigo_ciclo: codigo_ciclo },
            success: function(response) {
                console.log('Respuesta del Servidor:', response);
                // Rellenar el select de municipios con los datos obtenidos
                $('#codigo_materia').html(response);
            },
            error: function() {
                $('#codigo_materia').html('<option value="">Error al cargar materias</option>');
            }
        });
    });
});
