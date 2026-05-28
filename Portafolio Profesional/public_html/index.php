<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/includes/conexion.php';

/** @var mysqli $conexion */
global $conexion;

$resultado_bio = $conexion->query('SELECT * FROM biografia LIMIT 1');
if (!$resultado_bio) { die('Error SQL en biografia: ' . $conexion->error); }

$bio = $resultado_bio->fetch_assoc();
if (!$bio) { die('No hay datos en la tabla biografia.'); }

$habilidades = $conexion->query('SELECT * FROM habilidades ORDER BY id DESC');
$tecnologias = $conexion->query('SELECT * FROM tecnologias ORDER BY nivel DESC');
$proyectos   = $conexion->query('SELECT * FROM proyectos ORDER BY id DESC');

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


function resolver_demo_proyecto(array $p): string {
    $demo = trim((string)($p['demo_url'] ?? ''));
    if ($demo !== '' && $demo !== '#') {
        return $demo;
    }

    $titulo = mb_strtolower((string)($p['titulo'] ?? ''), 'UTF-8');

    if (str_contains($titulo, 'hash')) {
        return 'demos/hash-seguro.php';
    }
    if (str_contains($titulo, 'estudiante') || str_contains($titulo, 'registro')) {
        return 'demos/registro-estudiantes.php';
    }
    if (str_contains($titulo, 'tarea') || str_contains($titulo, 'gestor')) {
        return 'demos/gestor-tareas.php';
    }

    return 'demos/portfolio.php';
}

$portfolio_demos = [
  [
    'titulo'      => 'SyncStudy',
    'categoria'   => 'Creatividad y Prototipado',
    'descripcion' => 'Demo de calendario académico colaborativo para organizar tareas, evaluaciones y entregas semanales.',
    'icono'       => 'bi bi-calendar2-week',
    'tipo'        => 'syncstudy',
    'tecnologias' => ['HTML', 'CSS', 'JavaScript', 'Firebase'],
    'demo_url'    => 'demos/syncstudy.php',
  ],
  [
    'titulo'      => 'T E S T I G N',
    'categoria'   => 'Testing y documentación',
    'descripcion' => 'Vista demo para organizar criterios, evidencias y estados de avance de una evaluación técnica.',
    'icono'       => 'bi bi-ui-checks-grid',
    'tipo'        => 'testign',
    'tecnologias' => ['UX', 'Bootstrap', 'JS'],
    'demo_url'    => 'demos/testign.php',
  ],
  [
    'titulo'      => 'Cypress Testing',
    'categoria'   => 'Pruebas automatizadas',
    'descripcion' => 'Panel visual con resultados de pruebas automatizadas, casos positivos, negativos y de borde.',
    'icono'       => 'bi bi-bug',
    'tipo'        => 'cypress',
    'tecnologias' => ['Cypress', 'JavaScript', 'QA'],
    'demo_url'    => 'demos/cypress.php',
  ],
  [
    'titulo'      => 'WebVerbs',
    'categoria'   => 'Aplicación educativa',
    'descripcion' => 'Mini demo de búsqueda de verbos irregulares en inglés con traducción y formas principales.',
    'icono'       => 'bi bi-translate',
    'tipo'        => 'webverbs',
    'tecnologias' => ['Python', 'UI', 'Educación'],
    'demo_url'    => 'demos/webverbs.php',
  ],
  [
    'titulo'      => 'Hashing en Python',
    'categoria'   => 'Seguridad informática',
    'descripcion' => 'Demo visual para generar hashes SHA-256 desde el navegador como preview del proyecto académico.',
    'icono'       => 'bi bi-shield-lock',
    'tipo'        => 'hashing',
    'tecnologias' => ['Python', 'SHA-256', 'Seguridad'],
    'demo_url'    => 'demos/hashing.php',
  ],
  [
    'titulo'      => 'Portafolio Autoadministrable',
    'categoria'   => 'Desarrollo Web + IA',
    'descripcion' => 'Sistema web con PHP, MySQL, Bootstrap, login administrativo y gestión dinámica de contenido.',
    'icono'       => 'bi bi-window-stack',
    'tipo'        => 'portfolio',
    'tecnologias' => ['PHP', 'MySQL', 'Bootstrap'],
    'demo_url'    => 'demos/portfolio.php',
  ]
];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LSA Interactive | Portafolio Profesional</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Hoja de estilos propia — v=4 para limpiar caché -->
  <link rel="stylesheet" href="assets/css/style.css?v=10">
</head>

<!-- SIN bg-dark · SIN bg-black · SIN data-bs-theme="dark" -->
<body>

<!-- ======================================================
     NAVBAR — sin navbar-dark, sin bg-dark
     ====================================================== -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">

    <!-- Logo -->
    <a class="navbar-brand company-logo" href="index.php" aria-label="Ir al inicio">
      <div class="logo-box logo-symbol">
        <span class="shape shape1"></span>
        <span class="shape shape2"></span>
        <span class="shape shape3"></span>
      </div>
      <div class="logo-text">
        <span class="logo-title">LSA Interactive</span>
        <small class="logo-subtitle">Design &amp; Development</small>
      </div>
    </a>

    <!-- Toggler móvil -->
    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false"
            aria-label="Abrir menú">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Links -->
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


<!-- ======================================================
     HERO / BIOGRAFÍA — sin text-white, sin bg-dark
     ====================================================== -->
<header id="biografia" class="hero section-reveal">
  <div class="container">
    <div class="row align-items-center g-5">

      <!-- Foto -->
      <div class="col-md-5 text-center">
        <div class="profile-frame soft-float">
          <img src="<?= htmlspecialchars($bio['avatar']) ?>"
               class="img-fluid"
               alt="Avatar <?= htmlspecialchars($bio['nombre']) ?>">
        </div>
      </div>

      <!-- Texto -->
      <div class="col-md-7">
        <span class="eyebrow mb-3">Portafolio Profesional</span>
        <h1 class="display-4 fw-bold mb-3"><?= htmlspecialchars($bio['nombre']) ?></h1>
        <h2 class="h4 hero-subtitle mb-3"><?= htmlspecialchars($bio['titulo']) ?></h2>
        <p class="lead text-muted-custom mb-4"><?= htmlspecialchars($bio['descripcion']) ?></p>

        <div class="d-flex gap-3 flex-wrap justify-content-md-start justify-content-center">
          <a href="#proyectos" class="btn btn-primary">
            <i class="bi bi-grid me-2"></i>Ver Proyectos
          </a>
          <a href="#contacto" class="btn btn-outline-soft">
            <i class="bi bi-send me-2"></i>Contactar
          </a>
        </div>
      </div>

    </div>
  </div>
</header>


<!-- ======================================================
     HABILIDADES — sin clases oscuras
     ====================================================== -->
<section id="habilidades" class="py-5 section-reveal">
  <div class="container">
    <div class="text-center mb-5">
      <span class="eyebrow">Stack personal</span>
      <h2 class="section-title">Habilidades y Herramientas</h2>
      <p class="text-muted-custom">Tecnologías utilizadas en desarrollo web, diseño y soluciones interactivas.</p>
    </div>

    <div class="row g-4">
      <?php while ($h = $habilidades->fetch_assoc()): ?>
        <?php
          $imagenes = [
            'IA Web'      => 'ia.jpg',
            'GitHub'      => 'github.jpg',
            'Bootstrap'   => 'bootstrap.jpg',
            'MySQL'       => 'mysql.jpg',
            'PHP'         => 'php.jpg',
            'JavaScript'  => 'java.jpg',
            'CSS'         => 'css.jpg',
            'HTML'        => 'html.jpg'
          ];

          $descripciones = [
            'IA Web'      => 'Uso de inteligencia artificial aplicada al desarrollo web, automatización de procesos y mejora de experiencia de usuario.',
            'GitHub'      => 'Control de versiones, respaldo de proyectos, colaboración y presentación profesional del código.',
            'Bootstrap'   => 'Framework CSS para construir interfaces responsivas, ordenadas y mantenibles.',
            'MySQL'       => 'Base de datos relacional para almacenar, consultar y administrar información de sistemas web.',
            'PHP'         => 'Lenguaje backend para conectar páginas con bases de datos, formularios y paneles administrables.',
            'JavaScript'  => 'Interactividad, animaciones, validaciones y comportamiento dinámico dentro del navegador.',
            'CSS'         => 'Estilos visuales, espaciados, animaciones, diseño responsive y experiencia de usuario.',
            'HTML'        => 'Estructura principal del contenido web: secciones, formularios, tarjetas y navegación.'
          ];

          $imagen      = $imagenes[$h['nombre']]      ?? 'default.jpg';
          $descripcion = $descripciones[$h['nombre']] ?? 'Herramienta utilizada dentro del desarrollo web profesional.';
        ?>

        <div class="col-12 col-sm-6 col-lg-3">
          <article class="skill-card skill-grow-card p-4 h-100">
            <div class="skill-icon mb-3">
              <img src="assets/img/skills/<?= htmlspecialchars($imagen) ?>"
                   alt="<?= htmlspecialchars($h['nombre']) ?>"
                   class="skill-tool-img">
            </div>
            <h5 class="mb-2"><?= htmlspecialchars($h['nombre']) ?></h5>
            <p class="text-muted-custom mb-0"><?= htmlspecialchars($descripcion) ?></p>
          </article>
        </div>

      <?php endwhile; ?>
    </div>
  </div>
</section>


<!-- ======================================================
     TECNOLOGÍAS — sin fondos oscuros
     ====================================================== -->
<section id="tecnologias" class="py-5 section-reveal">
  <div class="container">
    <div class="glass-card p-4 p-md-5">
      <div class="text-center mb-5">
        <span class="eyebrow">Nivel actual</span>
        <h2 class="section-title">Tecnologías Dominadas</h2>
        <p class="text-muted-custom">Resumen visual de las tecnologías principales del portafolio.</p>
      </div>

      <div class="row g-4">
        <?php while ($t = $tecnologias->fetch_assoc()): ?>
        <div class="col-md-6">
          <div class="tech-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <strong class="text-main"><?= htmlspecialchars($t['nombre']) ?></strong>
              <span class="badge-soft">
                <?= htmlspecialchars($t['etiqueta']) ?> <?= (int)$t['nivel'] ?>%
              </span>
            </div>
            <div class="progress" role="progressbar"
                 aria-valuenow="<?= (int)$t['nivel'] ?>"
                 aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar" style="width: <?= (int)$t['nivel'] ?>%"></div>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</section>


<!-- ======================================================
     PROYECTOS / DEMOS — sin clases oscuras
     ====================================================== -->
<section id="proyectos" class="py-5 section-reveal">
  <div class="container">
    <div class="text-center mb-5">
      <span class="eyebrow">Portfolio demos</span>
      <h2 class="section-title">Proyectos Realizados</h2>
      <p class="text-muted-custom">Demos visuales e interactivas preparadas para conectar futuros repositorios de GitHub.</p>
    </div>

    <div class="row g-4">
      <?php foreach ($portfolio_demos as $demo): ?>
      <div class="col-md-6 col-xl-4">
        <article class="project-card demo-card h-100" id="demo-<?= htmlspecialchars($demo['tipo']) ?>">

          <!-- Cabecera -->
          <div class="project-card-head">
            <div class="project-icon">
              <i class="<?= htmlspecialchars($demo['icono']) ?>"></i>
            </div>
            <div>
              <span class="text-muted-custom"><?= htmlspecialchars($demo['categoria']) ?></span>
              <h5><?= htmlspecialchars($demo['titulo']) ?></h5>
            </div>
          </div>

          <!-- Descripción -->
          <p class="text-muted-custom mb-3"><?= htmlspecialchars($demo['descripcion']) ?></p>

          <!-- Preview visual (solo decorativa — el botón abre la demo real) -->
          <div class="demo-cover demo-cover-<?= htmlspecialchars($demo['tipo']) ?>">
            <div class="demo-browser">
              <span></span><span></span><span></span>
            </div>
            <div class="demo-cover-content">
              <i class="<?= htmlspecialchars($demo['icono']) ?>"></i>
              <strong>Demo interactivo</strong>
              <small>Se abre en una página propia al presionar "Ver Demo".</small>
            </div>
          </div>

          <!-- Tags de tecnologías -->
          <div class="tech-pills">
            <?php foreach ($demo['tecnologias'] as $tag): ?>
              <span><?= htmlspecialchars($tag) ?></span>
            <?php endforeach; ?>
          </div>

          <!-- Botones — NO eliminar ni cambiar -->
          <div class="d-flex gap-2 flex-wrap mt-auto">
            <a href="<?= htmlspecialchars($demo['demo_url']) ?>"
               target="_blank"
               class="btn btn-primary btn-sm">
              <i class="bi bi-play-circle me-1"></i>Ver Demo
            </a>
          </div>

        </article>
      </div>
      <?php endforeach; ?>
    </div>


    <!-- Proyectos administrables desde la BD -->
    <?php if ($proyectos && $proyectos->num_rows > 0): ?>
    <div class="admin-projects mt-5">
      <div class="text-center mb-4">
        <h3 class="h4 fw-bold">Proyectos administrables desde el panel</h3>
        <p class="text-muted-custom mb-0">
          Estos registros siguen conectados a la base de datos y se pueden editar desde el dashboard.
        </p>
      </div>
      <div class="row g-4">
        <?php while ($p = $proyectos->fetch_assoc()): ?>
        <?php
          $titulo_proyecto = $p['titulo'] ?? '';
          if (
            stripos($titulo_proyecto, 'Árbol')        !== false ||
            stripos($titulo_proyecto, 'Arbol')        !== false ||
            stripos($titulo_proyecto, 'Taller práctico') !== false ||
            stripos($titulo_proyecto, 'Taller practico') !== false
          ) { continue; }
        ?>
        <div class="col-md-6 col-lg-4">
          <article class="project-card h-100 overflow-hidden">
            <img src="<?= htmlspecialchars($p['imagen']) ?>"
                 class="card-img-top"
                 alt="Proyecto <?= htmlspecialchars($p['titulo']) ?>">
            <div class="p-4">
              <h5><?= htmlspecialchars($p['titulo']) ?></h5>
              <p class="text-muted-custom"><?= htmlspecialchars($p['descripcion']) ?></p>
              <div class="d-flex gap-2 flex-wrap">
                <a href="<?= htmlspecialchars(resolver_demo_proyecto($p)) ?>"
                   target="_blank"
                   class="btn btn-primary btn-sm">
                  <i class="bi bi-play-circle me-1"></i>Demo
                </a>
                </a>
              </div>
            </div>
          </article>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</section>


<!-- ======================================================
     CONTACTO — sin fondos oscuros
     ====================================================== -->
<section id="contacto" class="py-5 section-reveal">
  <div class="container">
    <div class="glass-card p-4 p-md-5">
      <div class="text-center mb-4">
        <span class="eyebrow">Conversemos</span>
        <h2 class="section-title">Contacto</h2>
        <p class="text-muted-custom mb-0">Puedes escribirme o revisar mis perfiles profesionales.</p>
      </div>

      <!-- Links de contacto -->
      <div class="contact-links-grid mb-4">
        <a class="contact-link-card" href="https://www.instagram.com/lleo_ab_/" target="_blank">
          <i class="bi bi-instagram"></i>
          <div><strong>Instagram</strong><span>@lleo_ab_</span></div>
        </a>
        <a class="contact-link-card" href="https://github.com/AguileraLeo" target="_blank">
          <i class="bi bi-github"></i>
          <div><strong>GitHub</strong><span>AguileraLeo</span></div>
        </a>
        <a class="contact-link-card"
           href="https://mail.google.com/mail/?view=cm&fs=1&to=leoaguilera.2026@gmail.com"
           target="_blank">
          <i class="bi bi-envelope-fill"></i>
          <div><strong>Correo</strong><span>leoaguilera.2026@gmail.com</span></div>
        </a>
        <a class="contact-link-card" href="https://wa.me/56981271992" target="_blank">
          <i class="bi bi-whatsapp"></i>
          <div><strong>WhatsApp</strong><span>+56 9 8127 1992</span></div>
        </a>
      </div>

      <!-- Alerta de éxito -->
      <?php if ($mensaje_exito): ?>
        <div class="alert alert-success"><?= htmlspecialchars($mensaje_exito) ?></div>
      <?php endif; ?>

      <!-- Formulario de contacto -->
      <form method="POST" class="contact-form">
        <div class="row g-3">
          <div class="col-md-6">
            <input type="text" name="nombre" class="form-control"
                   placeholder="Nombre" required>
          </div>
          <div class="col-md-6">
            <input type="email" name="correo" class="form-control"
                   placeholder="Correo electrónico" required>
          </div>
          <div class="col-12">
            <input type="text" name="asunto" class="form-control"
                   placeholder="Asunto" required>
          </div>
          <div class="col-12">
            <textarea name="mensaje" rows="5" class="form-control"
                      placeholder="Mensaje" required></textarea>
          </div>
          <div class="col-12 text-center">
            <button type="submit" name="enviar_contacto" class="btn btn-primary px-5">
              <i class="bi bi-send me-2"></i>Enviar Mensaje
            </button>
          </div>
        </div>
      </form>

    </div>
  </div>
</section>


<!-- ======================================================
     FOOTER — sin text-white ni bg-dark
     ====================================================== -->
<footer class="footer py-4">
  <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
    <p class="mb-0">
      © <span id="year"></span> <?= htmlspecialchars($bio['nombre']) ?>.
      Todos los derechos reservados.
    </p>
    <div class="fs-4 d-flex gap-3">
      <a href="https://github.com/AguileraLeo"         target="_blank" aria-label="GitHub"><i class="bi bi-github"></i></a>
      <a href="https://linkedin.com"                    target="_blank" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
      <a href="mailto:leoaguilera.2026@gmail.com"       aria-label="Correo"><i class="bi bi-envelope"></i></a>
    </div>
  </div>
</footer>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Script propio -->
<script src="assets/js/main.js?v=4"></script>

</body>
</html>