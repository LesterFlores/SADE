document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('table-body');
    const form = document.getElementById('formulario-datos');
    const saveBtn = document.getElementById('save-btn');
    const updateBtn = document.getElementById('update-btn');

    form.addEventListener('submit', function(e) {
        const pass = document.getElementById('pass').value;
        const passRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        if (!passRegex.test(pass)) {
            e.preventDefault();
            alert('La contraseña debe tener al menos 8 caracteres, una letra mayúscula, números y caracteres especiales.');
        }
    });

    tableBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-edit')) {
            const row = e.target.closest('tr');
            const id = row.getAttribute('data-id');
            const nombre = row.cells[1].textContent;
            const correo = row.cells[2].textContent;
            const contrasena = row.cells[3].textContent;
            const estado = row.cells[4].textContent === 'Activo' ? '1' : '0';

            document.getElementById('usuario-id').value = id;
            document.getElementById('nombreUsu').value = nombre;
            document.getElementById('correo').value = correo;
            document.getElementById('pass').value = contrasena;
            document.getElementById('estado').value = estado;

            saveBtn.style.display = 'none';
            updateBtn.style.display = 'block';
        }
    });
});
