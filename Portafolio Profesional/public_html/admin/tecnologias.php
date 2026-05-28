<?php
require_once '../includes/auth.php'; proteger_admin(); require_once '../includes/conexion.php'; require_once 'partials.php';
if (isset($_GET['eliminar'])) { $id=(int)$_GET['eliminar']; $conexion->query("DELETE FROM tecnologias WHERE id=$id"); header('Location: tecnologias.php'); exit; }
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $nivel=(int)$_POST['nivel'];
  if (!empty($_POST['id'])) { $stmt=$conexion->prepare('UPDATE tecnologias SET nombre=?, nivel=?, etiqueta=? WHERE id=?'); $stmt->bind_param('sisi', $_POST['nombre'], $nivel, $_POST['etiqueta'], $_POST['id']); }
  else { $stmt=$conexion->prepare('INSERT INTO tecnologias (nombre, nivel, etiqueta) VALUES (?,?,?)'); $stmt->bind_param('sis', $_POST['nombre'], $nivel, $_POST['etiqueta']); }
  $stmt->execute(); header('Location: tecnologias.php'); exit;
}
$edit = isset($_GET['editar']) ? $conexion->query('SELECT * FROM tecnologias WHERE id='.(int)$_GET['editar'])->fetch_assoc() : null;
$items = $conexion->query('SELECT * FROM tecnologias ORDER BY nivel DESC'); admin_header('Administrar Tecnologías');
?>
<div class="row g-4"><div class="col-lg-4"><div class="card admin-card p-4"><h5><?= $edit?'Editar':'Agregar' ?> tecnología</h5><form method="POST"><input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>"><div class="mb-3"><input name="nombre" class="form-control bg-white text-dark" placeholder="Nombre" value="<?= htmlspecialchars($edit['nombre'] ?? '') ?>" required></div><div class="mb-3"><input type="number" min="1" max="100" name="nivel" class="form-control bg-white text-dark" value="<?= htmlspecialchars($edit['nivel'] ?? '70') ?>" required></div><div class="mb-3"><input name="etiqueta" class="form-control bg-white text-dark" placeholder="Intermedio" value="<?= htmlspecialchars($edit['etiqueta'] ?? 'Intermedio') ?>" required></div><button class="btn btn-primary w-100">Guardar</button></form></div></div><div class="col-lg-8"><div class="card admin-card p-4"><table class="table"><thead><tr><th>Nombre</th><th>Nivel</th><th>Etiqueta</th><th>Acciones</th></tr></thead><tbody><?php while($r=$items->fetch_assoc()): ?><tr><td><?= htmlspecialchars($r['nombre']) ?></td><td><?= (int)$r['nivel'] ?>%</td><td><?= htmlspecialchars($r['etiqueta']) ?></td><td><a class="btn btn-sm btn-warning" href="?editar=<?= $r['id'] ?>">Editar</a> <a class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')" href="?eliminar=<?= $r['id'] ?>">Eliminar</a></td></tr><?php endwhile; ?></tbody></table></div></div></div>
<?php admin_footer(); ?>
