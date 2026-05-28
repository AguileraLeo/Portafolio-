<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'includes/conexion.php';

$resultado_bio = $conexion->query('SELECT * FROM biografia LIMIT 1');
if (!$resultado_bio) { die('Error SQL en biografia: ' . $conexion->error); }
$bio = $resultado_bio->fetch_assoc();
if (!$bio) { die('No hay datos en la tabla biografia. Importa database/sql_setup.sql.'); }

$habilidades = $conexion->query('SELECT * FROM habilidades ORDER BY id DESC');
if (!$habilidades) { die('Error SQL en habilidades: ' . $conexion->error); }
$tecnologias = $conexion->query('SELECT * FROM tecnologias ORDER BY nivel DESC');
if (!$tecnologias) { die('Error SQL en tecnologias: ' . $conexion->error); }
$proyectos = $conexion->query('SELECT * FROM proyectos ORDER BY id DESC');
if (!$proyectos) { die('Error SQL en proyectos: ' . $conexion->error); }

$mensaje_exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar_contacto'])) {
    $nombre  = trim($_POST['nombre']);
    $correo  = trim($_POST['correo']);
    $asunto  = trim($_POST['asunto']);
    $mensaje = trim($_POST['mensaje']);

    if ($nombre && $correo && $asunto && $mensaje) {
        $stmt = $conexion->prepare('INSERT INTO mensajes (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $nombre, $correo, $asunto, $mensaje);
        $stmt->execute();
        $mensaje_exito = 'Mensaje enviado correctamente.';
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portafolio Profesional</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- v=5 fuerza limpieza de caché -->
  <link href="assets/css/style2.css?v=5" rel="stylesheet">
</head>

<!-- SIN bg-dark · SIN text-white · SIN data-bs-theme="dark" -->
<body>

<!-- ============================================================
     NAVBAR — sin navbar-dark, sin bg-dark
     ============================================================ -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">

    <a class="navbar-brand brand-logo" href="index.php">
      <span class="brand-mark">LS</span>
      Leonardo Sebastian Aguilera Aburto
    </a>

    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false"
            aria-label="Abrir menú">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="#biografia">Biografía</a></li>
        <li class="nav-item"><a class="nav-link" href="#habilidades">Habilidades</a></li>
        <li class="nav-item"><a class="nav-link" href="#tecnologias">Tecnologías</a></li>
        <li class="nav-item"><a class="nav-link" href="#proyectos">Proyectos</a></li>
        <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
        <li class="nav-item ms-lg-3">
          <a class="btn btn-primary btn-sm" href="login.php">Iniciar Sesión</a>
        </li>
      </ul>
    </div>

  </div>
</nav>


<!-- ============================================================
     HERO / BIOGRAFÍA
     ============================================================ -->
<header id="biografia" class="hero section-reveal">
  <div class="container">
    <div class="row align-items-center g-5">

      <div class="col-md-5 text-center">
        <!-- Imagen con estilo neumorphic aplicado desde CSS -->
        <div class="profile-frame soft-float d-inline-flex">
          <img src="<?= htmlspecialchars($bio['avatar']) ?>"
               class="img-fluid"
               style="max-width:340px"
               alt="Avatar estudiante">
        </div>
      </div>

      <div class="col-md-7">
        <!-- Eyebrow / badge claro -->
        <span class="eyebrow mb-3">Portafolio Profesional</span>

        <h1 class="display-4 fw-bold mb-3"><?= htmlspecialchars($bio['nombre']) ?></h1>
        <h2 class="h4 hero-subtitle mb-3"><?= htmlspecialchars($bio['titulo']) ?></h2>
        <p class="lead text-muted-custom mb-4"><?= htmlspecialchars($bio['descripcion']) ?></p>

        <div class="d-flex gap-3 flex-wrap justify-content-md-start justify-content-center">
          <a href="#proyectos" class="btn btn-primary">
            <i class="bi bi-grid me-2"></i>Ver Proyectos
          </a>
          <!-- btn-outline-soft reemplaza btn-outline-light (evita estilos Bootstrap oscuros) -->
          <a href="#contacto" class="btn btn-outline-soft">
            <i class="bi bi-send me-2"></i>Contactar
          </a>
        </div>
      </div>

    </div>
  </div>
</header>


<!-- ============================================================
     HABILIDADES
     ============================================================ -->
<section id="habilidades" class="py-5 section-reveal">
  <div class="container">
    <div class="text-center mb-5">
      <span class="eyebrow">Stack personal</span>
      <h2 class="section-title">Habilidades y Herramientas</h2>
      <p class="text-muted-custom">Tecnologías utilizadas en desarrollo web.</p>
    </div>

    <div class="row g-4">
      <?php while ($h = $habilidades->fetch_assoc()): ?>
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="skill-card p-4 h-100">
          <!-- El estilo inline background del icono queda neutralizado desde CSS -->
          <div class="skill-icon mb-3">
            <i class="<?= htmlspecialchars($h['icono']) ?>"></i>
          </div>
          <h5 class="mb-1"><?= htmlspecialchars($h['nombre']) ?></h5>
          <p class="mb-0 text-muted-custom" style="font-size:.88rem;line-height:1.5">
            Herramienta utilizada en el desarrollo web profesional.
          </p>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>


<!-- ============================================================
     TECNOLOGÍAS
     ============================================================ -->
<section id="tecnologias" class="py-5 section-reveal">
  <div class="container">
    <div class="glass-card p-4 p-md-5">
      <div class="text-center mb-5">
        <span class="eyebrow">Nivel actual</span>
        <h2 class="section-title">Tecnologías Dominadas</h2>
        <p class="text-muted-custom">Nivel de dominio actual.</p>
      </div>

      <div class="row g-4">
        <?php while ($t = $tecnologias->fetch_assoc()): ?>
        <div class="col-md-6">
          <div class="tech-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <strong class="text-main"><?= htmlspecialchars($t['nombre']) ?></strong>
              <!-- badge-soft reemplaza text-bg-info de Bootstrap -->
              <span class="badge-soft">
                <?= htmlspecialchars($t['etiqueta']) ?> <?= (int)$t['nivel'] ?>%
              </span>
            </div>
            <div class="progress" role="progressbar"
                 aria-valuenow="<?= (int)$t['nivel'] ?>"
                 aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar" style="width:<?= (int)$t['nivel'] ?>%"></div>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</section>


<!-- ============================================================
     PROYECTOS
     ============================================================ -->
<section id="proyectos" class="py-5 section-reveal">
  <div class="container">
    <div class="text-center mb-5">
      <span class="eyebrow">Trabajos destacados</span>
      <h2 class="section-title">Proyectos Realizados</h2>
      <p class="text-muted-custom">Trabajos destacados del estudiante.</p>
    </div>

    <div class="row g-4">
      <?php while ($p = $proyectos->fetch_assoc()): ?>
      <div class="col-md-6 col-lg-4">
        <div class="project-card h-100 overflow-hidden">
          <img src="<?= htmlspecialchars($p['imagen']) ?>"
               class="card-img-top"
               alt="Proyecto <?= htmlspecialchars($p['titulo']) ?>">
          <div class="p-4">
            <h5><?= htmlspecialchars($p['titulo']) ?></h5>
            <p class="text-muted-custom"><?= htmlspecialchars($p['descripcion']) ?></p>
            <div class="d-flex gap-2 flex-wrap">
              <a href="<?= htmlspecialchars($p['demo_url']) ?>"
                 target="_blank"
                 class="btn btn-primary btn-sm">
                <i class="bi bi-play-circle me-1"></i>Demo
              </a>
              <!-- btn-outline-soft evita el fondo oscuro de btn-outline-light de Bootstrap -->
            </div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>


<!-- ============================================================
     CONTACTO
     ============================================================ -->
<section id="contacto" class="py-5 section-reveal">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="glass-card p-4 p-md-5">
          <div class="text-center mb-4">
            <span class="eyebrow">Conversemos</span>
            <h2 class="section-title">Formulario de Contacto</h2>
            <p class="text-muted-custom mb-0">Puedes escribirme directamente.</p>
          </div>

          <?php if ($mensaje_exito): ?>
            <div class="alert alert-success"><?= htmlspecialchars($mensaje_exito) ?></div>
          <?php endif; ?>

          <form method="POST" class="contact-form">
            <div class="row g-3">
              <div class="col-md-6">
                <input class="form-control" name="nombre" placeholder="Nombre" required>
              </div>
              <div class="col-md-6">
                <input type="email" class="form-control" name="correo"
                       placeholder="Correo electrónico" required>
              </div>
              <div class="col-12">
                <input class="form-control" name="asunto" placeholder="Asunto" required>
              </div>
              <div class="col-12">
                <textarea class="form-control" name="mensaje"
                          rows="5" placeholder="Mensaje" required></textarea>
              </div>
              <div class="col-12 text-center">
                <button class="btn btn-primary px-5" name="enviar_contacto" type="submit">
                  <i class="bi bi-send me-2"></i>Enviar Mensaje
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ============================================================
     FOOTER — sin bg-dark ni text-white
     ============================================================ -->
<footer class="footer py-4">
  <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
    <p class="mb-0">
      © <span id="year"></span> <?= htmlspecialchars($bio['nombre']) ?>.
      Todos los derechos reservados.
    </p>
    <div class="fs-4 d-flex gap-3">
      <a href="#" aria-label="GitHub"><i class="bi bi-github"></i></a>
      <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
      <a href="#" aria-label="Correo"><i class="bi bi-envelope"></i></a>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js?v=5"></script>

</body>
</html>