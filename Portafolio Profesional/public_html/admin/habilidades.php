<?php
require_once '../includes/auth.php'; proteger_admin(); require_once '../includes/conexion.php'; require_once 'partials.php';
if (isset($_GET['eliminar'])) { $id=(int)$_GET['eliminar']; $conexion->query("DELETE FROM habilidades WHERE id=$id"); header('Location: habilidades.php'); exit; }
if ($_SERVER['REQUEST_METHOD']==='POST') {
  if (!empty($_POST['id'])) { $stmt=$conexion->prepare('UPDATE habilidades SET nombre=?, icono=?, color=? WHERE id=?'); $stmt->bind_param('sssi', $_POST['nombre'], $_POST['icono'], $_POST['color'], $_POST['id']); }
  else { $stmt=$conexion->prepare('INSERT INTO habilidades (nombre, icono, color) VALUES (?,?,?)'); $stmt->bind_param('sss', $_POST['nombre'], $_POST['icono'], $_POST['color']); }
  $stmt->execute(); header('Location: habilidades.php'); exit;
}
$edit = isset($_GET['editar']) ? $conexion->query('SELECT * FROM habilidades WHERE id='.(int)$_GET['editar'])->fetch_assoc() : null;
$items = $conexion->query('SELECT * FROM habilidades ORDER BY id DESC'); admin_header('Administrar Habilidades');
?>
<div class="row g-4"><div class="col-lg-4"><div class="card admin-card p-4"><h5><?= $edit?'Editar':'Agregar' ?> habilidad</h5><form method="POST"><input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>"><div class="mb-3"><input name="nombre" class="form-control bg-white text-dark" placeholder="Nombre" value="<?= htmlspecialchars($edit['nombre'] ?? '') ?>" required></div><div class="mb-3"><input name="icono" class="form-control bg-white text-dark" placeholder="bi bi-code-slash" value="<?= htmlspecialchars($edit['icono'] ?? 'bi bi-code-slash') ?>" required></div><div class="mb-3"><input name="color" class="form-control bg-white text-dark" value="<?= htmlspecialchars($edit['color'] ?? '#3B82F6') ?>" required></div><button class="btn btn-primary w-100">Guardar</button></form></div></div><div class="col-lg-8"><div class="card admin-card p-4"><table class="table"><thead><tr><th>Nombre</th><th>Icono</th><th>Acciones</th></tr></thead><tbody><?php while($r=$items->fetch_assoc()): ?><tr><td><?= htmlspecialchars($r['nombre']) ?></td><td><i class="<?= htmlspecialchars($r['icono']) ?>"></i> <?= htmlspecialchars($r['icono']) ?></td><td><a class="btn btn-sm btn-warning" href="?editar=<?= $r['id'] ?>">Editar</a> <a class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')" href="?eliminar=<?= $r['id'] ?>">Eliminar</a></td></tr><?php endwhile; ?></tbody></table></div></div></div>
<?php admin_footer(); ?>
