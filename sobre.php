<?php
require_once __DIR__ . '/php/db.php';
require_once __DIR__ . '/php/layout.php';
initDB();

layout_header('Sobre mí', 'sobre');
?>

<div class="container">
  <div class="sobre-grid">

    <!-- SIDEBAR: TARJETA DE PERFIL ─────────────────────────── -->
    <aside>
      <div class="perfil-card">
        <div class="perfil-banner"></div>
        <div class="perfil-avatar-wrap">
          <div class="perfil-avatar">
            <img src="img/MegClaro.png" alt="Mi foto" class="logo-light">
            <img src="img/MegOscuro.png" alt="Mi foto" class="logo-dark">
          </div>
        </div>
        <div class="perfil-body">
          <div class="perfil-nombre">Dayana Obando</div>
          <div class="perfil-rol">Aprendiz de desarrollo · diseño web</div>
          <p class="perfil-bio">
            Estudiante de TI con interés en diseño, desarrollo web y arte digital.
          </p>
          <div>
            <div class="perfil-dato">
              <span class="perfil-dato-icon">📍</span>
              <span>Santo Domingo, Ecuador</span>
            </div>
            <div class="perfil-dato">
              <span class="perfil-dato-icon">🎓</span>
              <span>Ingeniería en Tecnología de la Información - UTPL</span>
            </div>
            <div class="perfil-dato">
              <span class="perfil-dato-icon">📧</span>
              <span>rominaobando2006@gmail.com</span>
            </div>
            <div class="perfil-dato">
              <span class="perfil-dato-icon">🌐</span>
              <span>Disponible para proyectos en front-end</span>
            </div>
          </div>
          <div style="margin-top:18px;">
            <a href="contacto.php" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;">
              Escríbeme →
            </a>
          </div>
        </div>
      </div>
    </aside>

    <!-- CONTENIDO PRINCIPAL ──────────────────────────────────── -->
    <main>

      <!-- BIO ── -->
      <div class="content-block">
        <div class="section-label">presentación</div>
        <h2 class="section-title" style="font-size:2rem;">Hola, soy <em>Dayana Obando</em></h2>
        <p>
          ¡Bienvenido a mi espacio digital! Soy estudiante de programación y este
          portafolio personal es mi proyecto académico APE, espero les guste.
        </p>
        <p>
          Me fascina el desarrollo web porque permite combinar lógica con creatividad y arte.
          Aún estoy aprendiendo y sé que tengo mucho por descubrir, pero aprendo en el proceso.
        </p>
      </div>

      <!-- HOBBIES ── -->
      <div class="content-block">
        <div class="section-label">intereses &amp; hobbies</div>
        <h3 style="font-size:1.25rem;margin-bottom:8px;">Gustos personales</h3>
        <p>Cosas que también alimentan mi forma de pensar y me apasionan son:</p>
        <div class="tags-wrap">
          <span class="tag">programación</span>
          <span class="tag">videojuegos</span>
          <span class="tag">lectura</span>
          <span class="tag">música</span>
          <span class="tag">café</span>
          <span class="tag">fotografía</span>
          <span class="tag">arte</span>
          <span class="tag">podcasts</span>
        </div>
      </div>

      <!-- PROYECTOS PERSONALES ── -->
      <div class="content-block">
        <div class="section-label">proyectos</div>
        <h3 style="font-size:1.25rem;margin-bottom:4px;">Proyectos personales</h3>
        <p style="margin-bottom:20px;">Lo que estoy construyendo:</p>

        <?php
        $proyectos = [
          [
            'nombre'     => "Girl's Diary Blog",
            'estado_key' => 'proceso',
            'desc'       => 'Un blog pensado para chicas: espacio de expresión, creatividad y comunidad. Estoy desarrollando el diseño y la estructura del sitio.',
            'img'        => 'img/proyecto-girls-diary.png',
            'img_alt'    => "Vista previa de Girl's Diary Blog",
          ],
          [
            'nombre'     => 'Study Space',
            'estado_key' => 'boceto',
            'desc'       => 'App de estudio con enfoque en el ambiente personal y emocional. La idea es que el entorno de estudio se adapte.',
            'img'        => 'img/proyecto-study-space.png',
            'img_alt'    => 'Boceto de Study Space',
          ],
          [
            'nombre'     => 'Blog Y2K — con Valerie',
            'estado_key' => 'idea',
            'desc'       => 'Blog de estética Y2K / 90s que estoy co-creando con mi compañera Valerie. Estilo visual retro, contenido general y mucha personalidad.',
            'img'        => 'img/proyecto-y2k-blog.png',
            'img_alt'    => 'Concepto del Blog Y2K',
          ],
          [
            'nombre'     => 'Portafolio Profesional',
            'estado_key' => 'idea',
            'desc'       => 'La versión profesional de este espacio, a futuro. Un portafolio más completo que muestre todo el recorrido y los proyectos terminados.',
            'img'        => 'img/proyecto-portafolio-pro.png',
            'img_alt'    => 'Concepto del Portafolio Profesional',
          ],
        ];

        $badges = [
          'proceso' => ['label' => 'En proceso', 'color' => 'var(--accent)'],
          'boceto'  => ['label' => 'En bocetos',  'color' => 'var(--accent-2, #9B8EC4)'],
          'idea'    => ['label' => 'Idea',         'color' => 'var(--text-3)'],
        ];
        ?>

        <div class="proyectos-grid">
          <?php foreach ($proyectos as $p):
            $badge   = $badges[$p['estado_key']];
            $imgFile = __DIR__ . '/' . $p['img'];
          ?>
          <div class="proyecto-card">
            <div class="proyecto-img-wrap">
              <?php if (file_exists($imgFile)): ?>
                <img src="<?= h($p['img']) ?>" alt="<?= h($p['img_alt']) ?>" loading="lazy">
              <?php else: ?>
                <div class="proyecto-placeholder">
                  <span class="proyecto-placeholder-icon">🖼</span>
                  <span class="proyecto-placeholder-text">imagen próximamente</span>
                </div>
              <?php endif; ?>
              <span class="proyecto-estado-badge" style="background:<?= $badge['color'] ?>">
                <?= $badge['label'] ?>
              </span>
            </div>
            <div class="proyecto-body">
              <div class="proyecto-nombre"><?= h($p['nombre']) ?></div>
              <p class="proyecto-desc"><?= h($p['desc']) ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- PROYECTO ACADÉMICO + BOCETOS ── -->
      <div class="content-block">
        <div class="section-label">proyecto académico</div>
        <h3 style="font-size:1.25rem;margin-bottom:8px;">¿Por qué este portafolio?</h3>
        <p>
          Este portafolio personal fue desarrollado como Actividad de Aprendizaje Práctico (APE)
          para aplicar programación orientada a eventos con PHP. El proyecto integra conexión
          a base de datos MySQL, formularios con validación en cliente y servidor, catálogo
          dinámico filtrable y modo claro/oscuro con CSS puro.
        </p>

        <!-- GALERÍA DE BOCETOS -->
        <div class="bocetos-section">
          <div class="bocetos-label">primeros bocetos</div>
          <div class="bocetos-grid">

            <?php
            $bocetos = [
              ['img' => 'img/boceto-1.png', 'caption' => 'Wireframe — página de inicio'],
              ['img' => 'img/boceto-2.png', 'caption' => 'Paleta de colores y tipografía'],
            ];
            foreach ($bocetos as $b):
              $imgFile = __DIR__ . '/' . $b['img'];
            ?>
            <div class="boceto-card">
              <?php if (file_exists($imgFile)): ?>
                <img src="<?= h($b['img']) ?>" alt="<?= h($b['caption']) ?>" loading="lazy">
              <?php else: ?>
                <div class="boceto-placeholder">
                  <span>✏️</span>
                  <span>boceto</span>
                </div>
              <?php endif; ?>
              <div class="boceto-caption"><?= h($b['caption']) ?></div>
            </div>
            <?php endforeach; ?>

          </div>
        </div>

        <div style="margin-top:24px;display:flex;gap:10px;flex-wrap:wrap;">
          <a href="coleccion.php" class="btn btn-primary btn-sm">Ver colección →</a>
          <a href="contacto.php"  class="btn btn-outline btn-sm">Contactar</a>
        </div>
      </div>

    </main>
  </div>
</div>

<?php layout_footer(); ?>
