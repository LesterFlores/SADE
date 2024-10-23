<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <form action="../acciones/usuarios.php" method="POST">
      <div class="form-group">
          <label for="email">Correo electrónico</label>
          <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
          <label for="password">Contraseña:</label>
          <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Iniciar sesión</button>
    </form>
  </div>

  <!-- Aquí se inyecta la alerta emergente si hay error -->
  <?php
  if (isset($_GET['alerta'])) {
    if ($_GET['alerta'] == 'error') {
      echo "
        <script>
          alert('Credenciales incorrectas. Por favor, intente nuevamente.');
        </script>
      ";
    } elseif ($_GET['alerta'] == 'desactivado') {
      echo "
        <script>
          alert('Su cuenta está desactivada. Por favor, contacte al administrador.');
        </script>
      ";
    }
  }
  
  ?>
</body>
</html>
