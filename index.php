<?php
require_once __DIR__ . '/php/db.php';
require_once __DIR__ . '/php/layout.php';
initDB();

$pdo = getDB();

// Piezas destacadas (máx. 4)
$destacados = $pdo->query("
    SELECT * FROM coleccion
    WHERE destacado = 1
    ORDER BY creado_en DESC
    LIMIT 4
")->fetchAll();

if (!$destacados) {
    $destacados = $pdo->query("
        SELECT * FROM coleccion
        ORDER BY creado_en DESC
        LIMIT 4
    ")->fetchAll();
}

$totalPiezas     = (int) $pdo->query("SELECT COUNT(*) FROM coleccion")->fetchColumn();
$totalCategorias = (int) $pdo->query("SELECT COUNT(DISTINCT categoria) FROM coleccion")->fetchColumn();

// Emojis por categoría (decoración visual)
$catEmoji = [
    'Diseño'      => '✏️',
    'Fotografía'  => '📷',
    'Código'      => '💻',
    'Arte Digital'=> '🎨',
    'Música'      => '🎵',
    'Escritura'   => '📝',
];

function getEmoji(string $cat, array $map): string {
    return $map[$cat] ?? '✦';
}

layout_header('Inicio', 'inicio');
?>

<!-- ── HERO ── -->
<section class="hero">
  <div class="container">
    <div class="hero-grid">

      <div>
        <span class="hero-eyebrow">bienvenido a mi espacio</span>
        <h1 class="hero-title">
          <em>Portafolio</em> <br>digital
          <span>archivo personal</span>
        </h1>
        <p class="hero-sub">
          En este espacio convive la tecnología, creatividad y las ideas en proceso.
Aquí comparto lo que construyo, lo que aprendo y aquello que despierta mi curiosidad.
        </p>
        <div style="display:flex;gap:12px;flex-wrap:wrap;">
          <a href="coleccion.php" class="btn btn-primary">Ver colección →</a>
          <a href="sobre.php"     class="btn btn-outline">Sobre mí</a>
        </div>

        <?php if ($totalPiezas > 0): ?>
        <div class="hero-stats">
          <div class="hero-stat">
            <div class="hero-stat-num"><?= $totalPiezas ?></div>
            <div class="hero-stat-label">piezas</div>
          </div>
          <?php if ($totalCategorias > 0): ?>
          <div class="hero-stat">
            <div class="hero-stat-num"><?= $totalCategorias ?></div>
            <div class="hero-stat-label">categorías</div>
          </div>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>

      <div class="hero-visual">
        <div class="hero-avatar">
          <img src="img/MegClaro.png" alt="Mi foto" class="logo-light">
          <img src="img/MegOscuro.png" alt="Mi foto" class="logo-dark">
        </div>
        <div style="text-align:center;margin-top:10px;">
          <div style="font-family:'Space Mono',monospace;font-size:.65rem;letter-spacing:.04em;color:var(--text-3);">Dayana Obando</div>
          <div style="font-size:.78rem;color:var(--text-2);margin-top:2px;">Interés en desarrollo · diseño</div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ── PIEZAS DESTACADAS ── -->
<div class="container" style="padding-bottom:20px;">
  <div class="coleccion-bar">
    <div>
      <div class="section-label">colección destacada</div>
      <h2 style="font-size:1.8rem;"><?= $destacados ? 'Piezas destacadas' : 'Últimas incorporaciones' ?></h2>
    </div>
    <a href="coleccion.php" class="btn btn-outline btn-sm">Ver todo →</a>
  </div>

  <?php if ($destacados): ?>
  <div class="coleccion-grid">
    <?php foreach ($destacados as $item): ?>
    <div class="item-card">
      <div class="item-img-wrap">
        <?php if ($item['imagen_url']): ?>
          <img src="<?= h($item['imagen_url']) ?>" alt="<?= h($item['titulo']) ?>" loading="lazy">
        <?php else: ?>
          <?= getEmoji($item['categoria'], $catEmoji) ?>
        <?php endif; ?>
        <?php if ($item['destacado']): ?>
          <span class="item-badge">Destacado</span>
        <?php endif; ?>
      </div>
      <div class="item-body">
        <div class="item-cat"><?= h($item['categoria']) ?></div>
        <div class="item-titulo"><?= h($item['titulo']) ?></div>
        <?php if ($item['descripcion']): ?>
          <div class="item-desc"><?= h($item['descripcion']) ?></div>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php else: ?>
  <div class="empty-state">
    <div class="empty-state-icon">✦</div>
    <h3>Colección vacía</h3>
    <p>Aún no hay piezas.</p>
  </div>
  <?php endif; ?>
</div>

<!-- ── CTA CONTACTO ── -->
<div class="container" style="padding-bottom:70px;">
  <div style="
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
    border-radius: var(--radius-xl);
    padding: 52px 48px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 24px;
  ">
    <div>
      <div style="font-family:'Space Mono',monospace;font-size:.68rem;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:8px;">¿tienes una idea?</div>
      <h2 style="color:#fff;font-size:2rem;margin-bottom:6px;">Hablemos</h2>
      <p style="color:rgba(255,255,255,.7);font-size:.9rem;font-weight:300;">
        Estoy interesada en colaboraciones, proyectos y charlas.
      </p>
    </div>
    <a href="contacto.php" class="btn" style="background:#fff;color:var(--accent);border:none;font-weight:500;">
      Escribíbeme →
    </a>
  </div>
</div>

<?php layout_footer(); ?>
