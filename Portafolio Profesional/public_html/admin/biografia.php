<?php
require_once '../includes/auth.php'; proteger_admin();
require_once '../includes/conexion.php'; require_once 'partials.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $conexion->prepare('UPDATE biografia SET nombre=?, titulo=?, descripcion=?, avatar=? WHERE id=1');
  $stmt->bind_param('ssss', $_POST['nombre'], $_POST['titulo'], $_POST['descripcion'], $_POST['avatar']);
  $stmt->execute();
}
$bio = $conexion->query('SELECT * FROM biografia LIMIT 1')->fetch_assoc();
admin_header('Administrar Biografía');
?>
<div class="card admin-card p-4"><form method="POST"><div class="mb-3"><label class="form-label">Nombre</label><input name="nombre" class="form-control bg-white text-dark" value="<?= htmlspecialchars($bio['nombre']) ?>" required></div><div class="mb-3"><label class="form-label">Título profesional</label><input name="titulo" class="form-control bg-white text-dark" value="<?= htmlspecialchars($bio['titulo']) ?>" required></div><div class="mb-3"><label class="form-label">Descripción</label><textarea name="descripcion" rows="5" class="form-control bg-white text-dark" required><?= htmlspecialchars($bio['descripcion']) ?></textarea></div><div class="mb-3"><label class="form-label">Ruta Avatar</label><input name="avatar" class="form-control bg-white text-dark" value="<?= htmlspecialchars($bio['avatar']) ?>"></div><button class="btn btn-primary">Guardar cambios</button></form></div>
<?php admin_footer(); ?>
