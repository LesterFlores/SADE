
    // Captura el campo de búsqueda
    document.querySelector('.input-busqueda').addEventListener('input', function() {
        // Captura el texto ingresado y lo convierte a minúsculas
        var filtro = this.value.toLowerCase();

        // Selecciona todas las filas del cuerpo de la tabla
        var filas = document.querySelectorAll('table tbody tr');

        // Itera a través de cada fila
        filas.forEach(function(fila) {
            // Obtiene el texto de la fila completa y lo convierte a minúsculas
            var textoFila = fila.textContent.toLowerCase();

            // Verifica si el texto de la fila incluye el texto del filtro
            if (textoFila.includes(filtro)) {
                // Si es así, muestra la fila
                fila.style.display = '';
            } else {
                // Si no, oculta la fila
                fila.style.display = 'none';
            }
        });
    });
