<?php
require_once '../includes/auth.php';
proteger_admin();
require_once '../includes/conexion.php';
require_once 'partials.php';

if (isset($_GET['eliminar'])) {
    $id = (int) $_GET['eliminar'];
    $conexion->query("DELETE FROM mensajes WHERE id = $id");
    header('Location: mensajes.php');
    exit;
}

$items = $conexion->query('SELECT * FROM mensajes ORDER BY id DESC');
admin_header('Mensajes de Contacto');
?>

<div class="card admin-card p-4">
  <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
      <h2 class="h5 fw-bold mb-1">Bandeja de mensajes</h2>
      <p class="text-secondary mb-0">
        Desde aquí puedes revisar los mensajes enviados desde el formulario y responder directamente al correo del visitante.
      </p>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Asunto</th>
          <th>Mensaje</th>
          <th>Fecha</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($r = $items->fetch_assoc()): ?>
          <?php
            $nombre  = $r['nombre'] ?? '';
            $correo  = $r['correo'] ?? '';
            $asunto  = $r['asunto'] ?? 'Consulta desde portafolio';
            $mensaje = $r['mensaje'] ?? '';

            $asunto_respuesta = 'Re: ' . $asunto;
            $cuerpo_respuesta = "Hola $nombre,\n\nGracias por contactarme desde mi portafolio.\n\n" .
                                "Te respondo sobre tu mensaje:\n\n" .
                                "\"$mensaje\"\n\n" .
                                "Saludos,\nLeonardo Aguilera";

            $gmail_url = 'https://mail.google.com/mail/?view=cm&fs=1'
                       . '&to=' . rawurlencode($correo)
                       . '&su=' . rawurlencode($asunto_respuesta)
                       . '&body=' . rawurlencode($cuerpo_respuesta);

            $mailto_url = 'mailto:' . rawurlencode($correo)
                        . '?subject=' . rawurlencode($asunto_respuesta)
                        . '&body=' . rawurlencode($cuerpo_respuesta);
          ?>
          <tr>
            <td class="fw-semibold"><?= htmlspecialchars($nombre) ?></td>
            <td>
              <a href="mailto:<?= htmlspecialchars($correo) ?>" class="text-decoration-none">
                <?= htmlspecialchars($correo) ?>
              </a>
            </td>
            <td><?= htmlspecialchars($asunto) ?></td>
            <td style="max-width: 360px; white-space: normal;">
              <?= nl2br(htmlspecialchars($mensaje)) ?>
            </td>
            <td><?= htmlspecialchars($r['creado_en'] ?? '') ?></td>
            <td class="text-end">
              <div class="d-flex flex-wrap justify-content-end gap-2">
                <a class="btn btn-primary btn-sm"
                   href="<?= htmlspecialchars($gmail_url) ?>"
                   target="_blank"
                   rel="noopener">
                  <i class="bi bi-envelope-paper me-1"></i>Responder Gmail
                </a>

                <a class="btn btn-outline-danger btn-sm"
                   onclick="return confirm('¿Eliminar este mensaje?')"
                   href="?eliminar=<?= (int) $r['id'] ?>">
                  <i class="bi bi-trash me-1"></i>Eliminar
                </a>
              </div>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php admin_footer(); ?>
