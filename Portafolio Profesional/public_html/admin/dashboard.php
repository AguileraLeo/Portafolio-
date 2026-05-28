<?php
require_once '../includes/auth.php'; proteger_admin();
require_once '../includes/conexion.php'; require_once 'partials.php';
$stats = [
 'Habilidades' => $conexion->query('SELECT COUNT(*) c FROM habilidades')->fetch_assoc()['c'],
 'Tecnologías' => $conexion->query('SELECT COUNT(*) c FROM tecnologias')->fetch_assoc()['c'],
 'Proyectos' => $conexion->query('SELECT COUNT(*) c FROM proyectos')->fetch_assoc()['c'],
 'Mensajes' => $conexion->query('SELECT COUNT(*) c FROM mensajes')->fetch_assoc()['c'],
];
admin_header('Dashboard');
?>
<div class="row g-4">
<?php foreach($stats as $k=>$v): ?>
 <div class="col-md-6 col-xl-3"><div class="card admin-card p-4"><h6 class="text-secondary"><?= $k ?></h6><h2 class="fw-bold mb-0"><?= $v ?></h2></div></div>
<?php endforeach; ?>
</div>
<div class="card admin-card mt-4 p-4"><h5 class="fw-bold">Bienvenido, <?= htmlspecialchars($_SESSION['admin_nombre']) ?></h5><p class="mb-0 text-secondary">Desde este panel puedes administrar la biografía, habilidades, tecnologías, proyectos y mensajes del portafolio.</p></div>
<?php admin_footer(); ?>
