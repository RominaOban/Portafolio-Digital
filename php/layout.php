<?php
// php/layout.php — Header y footer compartidos

function _base(): string {
    return strpos($_SERVER['PHP_SELF'], '/php/') !== false ? '../' : '';
}

function layout_header(string $titulo, string $paginaActiva = ''): void {
    $base = _base();
?>
<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= h($titulo) ?> — Studio</title>
  <link rel="stylesheet" href="<?= $base ?>css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,300;1,9..144,400&family=Space+Mono:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>✦</text></svg>">
</head>
<body>

<!-- PIXEL ART DECORATION (dots) -->
<div class="pixel-bg" aria-hidden="true"></div>

<header class="site-header">
  <div class="container">
    <nav class="nav-inner">
      <a href="<?= $base ?>index.php" class="nav-brand">
        <img src="<?= $base ?>img/MegClaro.png" alt="Studio" class="logo-light" height="36">
        <img src="<?= $base ?>img/MegOscuro.png" alt="Studio" class="logo-dark"  height="36">
      </a>
      <div class="nav-links">
        <a href="<?= $base ?>index.php"    class="nav-link <?= $paginaActiva === 'inicio'    ? 'active' : '' ?>">Inicio</a>
        <a href="<?= $base ?>coleccion.php" class="nav-link <?= $paginaActiva === 'coleccion' ? 'active' : '' ?>">Colección</a>
        <a href="<?= $base ?>sobre.php"    class="nav-link <?= $paginaActiva === 'sobre'     ? 'active' : '' ?>">Sobre mí</a>
        <a href="<?= $base ?>contacto.php" class="nav-link nav-cta <?= $paginaActiva === 'contacto'  ? 'active' : '' ?>">Contacto</a>
        <switch class="theme-toggle" id="themeToggle" aria-label="Cambiar tema">
          <span class="theme-icon-light">☀</span>
          <span class="theme-icon-dark">◑</span>
        </switch>
      </div>
    </nav>
  </div>
</header>

<main>
<?php
}

function layout_footer(): void {
    $base = _base();
?>
</main>

<footer class="site-footer">
  <div class="container">
    <div class="footer-inner">
      <div class="footer-left">
        <a href="<?= $base ?>index.php" style="display:flex;align-items:center;">
          <img src="<?= $base ?>img/MegClaro.png" alt="Studio" class="logo-light" height="28">
          <img src="<?= $base ?>img/MegOscuro.png" alt="Studio" class="logo-dark"  height="28">
        </a>
        <span class="footer-sep">—</span>
        <span class="footer-note">Proyecto académico · PHP &amp; MySQL</span>
      </div>
      <nav class="footer-links">
        <a href="<?= $base ?>index.php">Inicio</a>
        <a href="<?= $base ?>coleccion.php">Colección</a>
        <a href="<?= $base ?>sobre.php">Sobre mí</a>
        <a href="<?= $base ?>contacto.php">Contacto</a>
      </nav>
    </div>
  </div>
</footer>

<script>
// ── THEME TOGGLE ──────────────────────────────────────────────
(function() {
  const html   = document.documentElement;
  const btn    = document.getElementById('themeToggle');
  const stored = localStorage.getItem('theme') || 'light';
  html.setAttribute('data-theme', stored);

  btn && btn.addEventListener('click', () => {
    const next = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    html.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
  });
})();
</script>
</body>
</html>
<?php
}
?>
