<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hidden Sound Atlas</title>
    <link rel="stylesheet" href="/Proyecto_BlogPHP/public/css/style.css">
</head>

<body class="auth-body home-public-body">

    <!-- CUADRO CENTRAL -->
    <div class="auth-container home-welcome-box">

        <!-- NUEVO BLOQUE: LOGO + TÍTULOS -->
        <div class="welcome-header">
        <img src="/Proyecto_BlogPHP/public/img_posts/logo_hsa.png"
            alt="Hidden Sound Atlas Logo"
            class="hsa-logo">

        <div class="welcome-titles">
            <h1>Hidden Sound Atlas</h1>
            <h2>Mapa Sonoro · Zona Pública</h2>
        </div>
    </div>

        <!-- FIN NUEVO BLOQUE -->

        <p class="auth-footnote" style="margin-top:10px;">
            Bienvenido al portal. Aquí descubrirás sonidos ocultos,
            artistas alternativos y rincones oscuros del panorama musical.
            <br>
            Una invitación a explorar mapas sonoros que no aparecen en ningún algoritmo.
        </p>

        <div class="home-welcome-buttons">
            <a href="/Proyecto_BlogPHP/public/?controller=auth&action=loginForm" 
               class="auth-link" style="font-size:1.1rem; text-align:center;">
                Entrar en The Blue Room
            </a>

            <a href="/Proyecto_BlogPHP/public/?controller=register&action=registerForm" 
               class="auth-link" style="font-size:1.1rem; text-align:center;">
                Crear cuenta nueva
            </a>
        </div>

        <p class="auth-footnote" style="margin-top:25px;">
            The Blue Room es la zona privada donde podrás leer los posts completos.
        </p>

    </div>


    <!-- PREVIEW LISTA DE 2 POSTS -->
    <section class="home-posts-section">

        <h3 style="color:#8fbaff; text-align:center; margin-bottom:25px;">
            Últimos descubrimientos del mapa sonoro
        </h3>

        <?php if (!empty($publicPosts)) : ?>

            <?php foreach ($publicPosts as $post): ?>
                <article class="home-post-card">

                    <!-- Portada -->
                    <?php if (!empty($post['image'])) : ?>
                        <img src="/Proyecto_BlogPHP/public<?= htmlspecialchars($post['image']) ?>" 
                             alt="cover"
                             class="home-post-image">
                    <?php endif; ?>

                    <div class="home-post-content">

                        <h4 style="color:#dce6ff; margin-bottom:4px; font-size:1.1rem;">
                            <?= htmlspecialchars($post['title']) ?>
                        </h4>

                        <?php if (!empty($post['subtitle'])) : ?>
                            <p style="color:#9bb0d3; font-size:0.9rem; margin-bottom:6px;">
                                <em><?= htmlspecialchars($post['subtitle']) ?></em>
                            </p>
                        <?php endif; ?>

                        <p style="color:#9bb0d3; font-size:0.9rem; margin-bottom:6px;">
                            <?= htmlspecialchars(mb_substr($post['content'], 0, 150)) ?>...
                        </p>

                        <a href="/Proyecto_BlogPHP/public/?controller=auth&action=loginForm"
                           style="color:#8fbaff; font-size:0.9rem;">
                            Seguir leyendo →
                        </a>

                    </div>

                </article>
            <?php endforeach; ?>

        <?php else: ?>

            <p style="text-align:center; color:#8899bb;">
                Aún no hay descubrimientos publicados.
            </p>

        <?php endif; ?>

    </section>

</body>
</html>
