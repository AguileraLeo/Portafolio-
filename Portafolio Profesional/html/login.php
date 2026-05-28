<?php
session_start();
require_once 'includes/conexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conexion->prepare('SELECT * FROM admins WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id']     = $admin['id'];
        $_SESSION['admin_nombre'] = $admin['nombre'];
        header('Location: admin/dashboard.php');
        exit;
    }

    $error = 'Credenciales incorrectas. Verifica tu correo y contraseña.';
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Administrativo — LSA Interactive</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- v=5 fuerza limpieza de caché -->
  <link href="assets/css/style2.css?v=5" rel="stylesheet">
</head>

<!-- Sin bg-dark · Sin data-bs-theme="dark" -->
<body>

<main class="min-vh-100 d-flex align-items-center justify-content-center p-3">
  <div class="glass-card p-4 p-md-5 login-card">

    <!-- Ícono decorativo -->
    <div class="login-icon">
      <i class="bi bi-shield-lock"></i>
    </div>

    <!-- Encabezado -->
    <h1 class="h3 fw-bold text-center mb-1">Panel Administrativo</h1>
    <p class="text-muted-custom text-center mb-4" style="font-size:.92rem">
      Acceso restringido · LSA Interactive
    </p>

    <!-- Alerta de error -->
    <?php if ($error): ?>
      <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
        <i class="bi bi-exclamation-circle-fill"></i>
        <span><?= htmlspecialchars($error) ?></span>
      </div>
    <?php endif; ?>

    <!-- Formulario de login -->
    <form method="POST" autocomplete="on">

      <div class="mb-3">
        <label for="login-email" class="form-label">
          <i class="bi bi-envelope me-1"></i>Correo electrónico
        </label>
        <input type="email"
               id="login-email"
               name="email"
               class="form-control"
               value="admin@demo.cl"
               placeholder="correo@dominio.cl"
               autocomplete="username"
               required>
      </div>

      <div class="mb-4">
        <label for="login-password" class="form-label">
          <i class="bi bi-lock me-1"></i>Contraseña
        </label>
        <div class="position-relative">
          <input type="password"
                 id="login-password"
                 name="password"
                 class="form-control"
                 placeholder="••••••••"
                 autocomplete="current-password"
                 required>
          <!-- Toggle mostrar/ocultar contraseña -->
          <button type="button"
                  class="btn-toggle-pass"
                  onclick="togglePass()"
                  aria-label="Mostrar contraseña"
                  tabindex="-1">
            <i class="bi bi-eye" id="pass-icon"></i>
          </button>
        </div>
      </div>

      <button class="btn btn-primary w-100 mb-3" type="submit">
        <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
      </button>

      <a href="index.php" class="btn btn-back-portfolio w-100">
        <i class="bi bi-arrow-left me-2"></i>Volver al Portafolio
      </a>

    </form>

  </div>
</main>


<!-- Script toggle de contraseña -->
<script>
  function togglePass() {
    const input = document.getElementById('login-password');
    const icon  = document.getElementById('pass-icon');
    if (input.type === 'password') {
      input.type    = 'text';
      icon.className = 'bi bi-eye-slash';
    } else {
      input.type    = 'password';
      icon.className = 'bi bi-eye';
    }
  }
</script>

<!-- Estilos específicos del login (pequeños, no justifican un bloque en style.css) -->
<style>
  /* Botón ojo dentro del campo contraseña */
  .btn-toggle-pass {
    position:      absolute;
    right:         14px;
    top:           50%;
    transform:     translateY(-50%);
    background:    transparent;
    border:        none;
    padding:       0;
    color:         var(--text-soft);
    font-size:     1.05rem;
    cursor:        pointer;
    transition:    color .2s ease;
    box-shadow:    none !important;
  }
  .btn-toggle-pass:hover { color: var(--primary-dark); }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>