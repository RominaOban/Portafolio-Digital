<?php
require_once __DIR__ . '/php/db.php';
require_once __DIR__ . '/php/layout.php';
initDB();

$pdo = getDB();

// Filtros
$catFiltro = trim($_GET['cat'] ?? '');
$busqueda  = trim($_GET['q']   ?? '');

$categorias = $pdo->query(
    "SELECT DISTINCT categoria FROM coleccion ORDER BY categoria ASC"
)->fetchAll(PDO::FETCH_COLUMN);

$where  = [];
$params = [];

if ($catFiltro !== '') {
    $where[]       = 'categoria = :cat';
    $params[':cat'] = $catFiltro;
}
if ($busqueda !== '') {
    $where[]       = '(titulo LIKE :q OR descripcion LIKE :q2 OR categoria LIKE :q3)';
    $params[':q']  = "%$busqueda%";
    $params[':q2'] = "%$busqueda%";
    $params[':q3'] = "%$busqueda%";
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';
$sql = "SELECT * FROM coleccion $whereSQL ORDER BY destacado DESC, creado_en DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$items = $stmt->fetchAll();
$total = count($items);

$catEmoji = [
    'Diseño'      => '✏️',
    'Fotografía'  => '📷',
    'Código'      => '💻',
    'Arte Digital'=> '🎨',
];
function getEmoji(string $cat, array $map): string { return $map[$cat] ?? '✦'; }

layout_header('Colección', 'coleccion');
?>

<div class="container">

 // HEADER  
  <div class="page-header">
    <div class="section-label">Archivo creativo</div>
    <h1>
      Colección
      <?php if ($catFiltro): ?><em> — <?= h($catFiltro) ?></em><?php endif; ?>
    </h1>
    <p>Proyectos, experimentos y creaciones organizadas por disciplina.</p>
    <div class="coleccion-count">
      <?= $total ?> Pieza<?= $total !== 1 ? 's' : '' ?> encontrada<?= $total !== 1 ? 's' : '' ?>
      <?php if ($busqueda): ?> para "<?= h($busqueda) ?>"<?php endif; ?>
    </div>
  </div>

  <!-- BUSCADOR ─────────────────────────────────────────────── -->
  <form method="GET" action="coleccion.php">
    <?php if ($catFiltro): ?>
      <input type="hidden" name="cat" value="<?= h($catFiltro) ?>">
    <?php endif; ?>
    <div class="search-wrap">
      <input
        type="search"
        name="q"
        placeholder="Buscar en la colección..."
        value="<?= h($busqueda) ?>"
        autocomplete="off"
      >
      <button type="submit">Buscar</button>
    </div>
  </form>

  <!-- FILTROS ─────────────────────────────────────────────── -->
  <?php if ($categorias): ?>
  <div class="filter-bar">
    <a href="coleccion.php<?= $busqueda ? '?q=' . urlencode($busqueda) : '' ?>"
       class="filter-btn <?= $catFiltro === '' ? 'active' : '' ?>">
      Todo
    </a>
    <?php foreach ($categorias as $cat):
      $url = 'coleccion.php?cat=' . urlencode($cat);
      if ($busqueda) $url .= '&q=' . urlencode($busqueda);
    ?>
    <a href="<?= $url ?>"
       class="filter-btn <?= $catFiltro === $cat ? 'active' : '' ?>">
      <?= getEmoji($cat, $catEmoji) ?> <?= h($cat) ?>
    </a>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <!-- GRID ─────────────────────────────────────────────────── -->
  <?php if ($items): ?>
  <div class="coleccion-grid">
    <?php foreach ($items as $item): ?>
    <div class="item-card">
      <div class="item-img-wrap">
        <?php if ($item['imagen_url']): ?>
          <img src="<?= h($item['imagen_url']) ?>" alt="<?= h($item['titulo']) ?>" loading="lazy">
        <?php else: ?>
          <div class="item-img-placeholder">
            <span><?= getEmoji($item['categoria'], $catEmoji) ?></span>
            <small>imagen pendiente</small>
          </div>
        <?php endif; ?>
        <?php if ($item['destacado']): ?>
          <span class="item-badge">✦</span>
        <?php endif; ?>
      </div>
      <div class="item-body">
        <div class="item-cat"><?= h($item['categoria']) ?></div>
        <div class="item-titulo"><?= h($item['titulo']) ?></div>
        <?php if ($item['descripcion']): ?>
          <div class="item-desc"><?= h($item['descripcion']) ?></div>
        <?php endif; ?>
        <?php if (!empty($item['fuente'])): ?>
          <div class="item-fuente">vía <?= h($item['fuente']) ?></div>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <?php else: ?>
  <div class="empty-state">
    <div class="empty-state-icon">🔍</div>
    <h3>Sin resultados</h3>
    <p>
      <?php if ($busqueda): ?>
        No encontramos piezas que coincidan con "<?= h($busqueda) ?>".
      <?php else: ?>
        No hay piezas en esta categoría todavía.
      <?php endif; ?>
    </p>
    <div style="margin-top:20px;">
      <a href="coleccion.php" class="btn btn-outline btn-sm">Ver toda la colección</a>
    </div>
  </div>
  <?php endif; ?>

</div>

<?php layout_footer(); ?>
