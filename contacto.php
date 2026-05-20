<?php
require_once __DIR__ . '/php/db.php';
require_once __DIR__ . '/php/layout.php';
initDB();

$msg_ok    = '';
$msg_error = '';
$v = ['nombre' => '', 'correo' => '', 'mensaje' => ''];

// ── PROCESAMIENTO ─────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre  = trim(strip_tags($_POST['nombre']  ?? ''));
    $correo  = trim(strip_tags($_POST['correo']  ?? ''));
    $mensaje = trim(strip_tags($_POST['mensaje'] ?? ''));

    $v = compact('nombre', 'correo', 'mensaje');

    $errores = [];

    if (mb_strlen($nombre) < 2 || mb_strlen($nombre) > 100)
        $errores[] = 'El nombre debe tener entre 2 y 100 caracteres.';

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || mb_strlen($correo) > 150)
        $errores[] = 'Ingresa un correo electrónico válido.';

    if (mb_strlen($mensaje) < 10 || mb_strlen($mensaje) > 2000)
        $errores[] = 'El mensaje debe tener entre 10 y 2 000 caracteres.';

    if ($errores) {
        $msg_error = implode('<br>', $errores);
    } else {
        try {
            $pdo  = getDB();
            $stmt = $pdo->prepare(
                "INSERT INTO mensajes (nombre, correo, mensaje)
                 VALUES (:nombre, :correo, :mensaje)"
            );
            $stmt->execute([
                ':nombre'  => $nombre,
                ':correo'  => $correo,
                ':mensaje' => $mensaje,
            ]);

            $msg_ok = h($nombre);
            $v = ['nombre' => '', 'correo' => '', 'mensaje' => ''];

        } catch (PDOException $ex) {
            error_log('Contacto DB error: ' . $ex->getMessage());
            $msg_error = 'Error al guardar el mensaje. Por favor intenta nuevamente.';
        }
    }
}

layout_header('Contacto', 'contacto');
?>

<div class="container">
  <div class="contacto-grid">

    <!-- FORMULARIO ───────────────────────────────────────────── -->
    <div>
      <?php if ($msg_ok): ?>

        <!-- ÉXITO -->
        <div class="success-box">
          <div class="success-icon">✦</div>
          <div class="success-title">¡Mensaje enviado!</div>
          <p class="success-text">
            Gracias, <strong><?= $msg_ok ?></strong>.<br>
            Recibí tu mensaje y te escribiré pronto al correo indicado.
          </p>
          <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
            <a href="contacto.php"  class="btn btn-outline btn-sm">enviar otro</a>
            <a href="coleccion.php" class="btn btn-primary btn-sm">ver colección →</a>
          </div>
        </div>

      <?php else: ?>

        <!-- FORM -->
        <div class="form-card">
          <div class="section-label">formulario</div>
          <h1 class="form-title">Hablemos</h1>
          <p class="form-sub">
            ¿Tienes un proyecto, una idea o simplemente quieres saludar?
            Escríbeme y te respondo pronto!.
          </p>

          <?php if ($msg_error): ?>
            <div class="alert alert-error">
              <span>⚠️</span>
              <div><?= $msg_error ?></div>
            </div>
          <?php endif; ?>

          <form method="POST" novalidate>

            <div class="form-row">
              <div class="form-group">
                <label for="nombre">nombre completo</label>
                <input
                  type="text"
                  id="nombre"
                  name="nombre"
                  value="<?= h($v['nombre']) ?>"
                  placeholder="Tu nombre"
                  required
                  minlength="2"
                  maxlength="100"
                  autocomplete="name"
                >
              </div>
              <div class="form-group">
                <label for="correo">correo electrónico</label>
                <input
                  type="email"
                  id="correo"
                  name="correo"
                  value="<?= h($v['correo']) ?>"
                  placeholder="tucorreo@ejemplo.com"
                  required
                  maxlength="150"
                  autocomplete="email"
                >
              </div>
            </div>

            <div class="form-group">
              <label for="mensaje">mensaje</label>
              <textarea
                id="mensaje"
                name="mensaje"
                required
                minlength="10"
                maxlength="2000"
                placeholder="Cuéntame en qué puedo ayudarte..."
              ><?= h($v['mensaje']) ?></textarea>
              <div style="text-align:right;font-family:'Space Mono',monospace;font-size:.65rem;color:var(--text-3);margin-top:4px;">
                <span id="charCount"><?= mb_strlen($v['mensaje']) ?></span> / 2000
              </div>
            </div>

            <button type="submit" class="btn btn-primary btn-full">
              Enviar
            </button>

          </form>
        </div>

      <?php endif; ?>
    </div>

    <!-- SIDEBAR ────────────────────────────────────────────── -->
    <aside>

      <div class="info-card">
        <div class="info-card-title">Proyectos y colaboraciones</div>
        <p class="info-card-text">
          ¿Tienes una idea que quieras desarrollar? Estoy
          interesada en colaborar y aprender sobre tu proyecto web creativo.
        </p>
      </div>

      <div class="info-card">
        <div class="info-card-title">Tiempo de respuesta</div>
        <p class="info-card-text">
          Leo todos los mensajes y respondo en un plazo de
          8 días hábiles.
        </p>
      </div>

      <div class="info-card">
        <div class="info-card-title">Privacidad</div>
        <p class="info-card-text">
          Tienes que saber que datos solo se usan para responder tu consulta.
          No se comparten con terceros.
        </p>
      </div>

      <div style="margin-top:8px;">
        <a href="coleccion.php" class="btn btn-outline" style="width:100%;justify-content:center;">
          ← Ver colección
        </a>
      </div>

    </aside>

  </div>
</div>

<script>
const textarea  = document.getElementById('mensaje');
const charCount = document.getElementById('charCount');
if (textarea && charCount) {
    textarea.addEventListener('input', () => {
        charCount.textContent = textarea.value.length;
    });
}
</script>

<?php layout_footer(); ?>
