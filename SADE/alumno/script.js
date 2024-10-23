// script.js

$(document).ready(function() {
    $('#departamento').change(function() {
        var codigo_departamento = $(this).val();
        console.log('Código Departamento:', codigo_departamento);

        // Limpiar el select de municipios
        $('#municipio').html('<option value="">Cargando...</option>');

        // Hacer la solicitud AJAX para obtener los municipios
        $.ajax({
            url: '../alumno/get_municipios.php', // Ruta del archivo PHP que obtendrá los municipios
            type: 'POST',
            data: { codigo_departamento: codigo_departamento },
            success: function(response) {
                console.log('Respuesta del Servidor:', response);
                // Rellenar el select de municipios con los datos obtenidos
                $('#municipio').html(response);
            },
            error: function() {
                $('#municipio').html('<option value="">Error al cargar municipios</option>');
            }
        });
    });
});
