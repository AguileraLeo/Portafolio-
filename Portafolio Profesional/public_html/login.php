<?php
session_start();
require_once 'includes/conexion.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $stmt = $conexion->prepare('SELECT * FROM admins WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nombre'] = $admin['nombre'];
        header('Location: admin/dashboard.php');
        exit;
    }
    $error = 'Credenciales incorrectas.';
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Login Admin</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="assets/css/style.css?v=10" rel="stylesheet"></head>
<body><main class="min-vh-100 d-flex align-items-center justify-content-center p-3"><div class="glass-card p-4 p-md-5" style="max-width:430px;width:100%"><h1 class="h3 fw-bold text-center mb-2">Login Administrativo</h1><p class="text-muted-custom text-center mb-4">Acceso restringido al dashboard</p><?php if($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?><form method="POST"><div class="mb-3"><label class="form-label">Correo</label><input type="email" name="email" class="form-control" value="admin@demo.cl" required></div><div class="mb-4"><label class="form-label">Contraseña</label><input type="password" name="password" class="form-control" placeholder="admin123" required></div><button class="btn btn-primary w-100" type="submit">Ingresar</button><a href="index.php" class="btn btn-outline-primary w-100 mt-3">Volver al portafolio</a></form></div></main></body></html>
