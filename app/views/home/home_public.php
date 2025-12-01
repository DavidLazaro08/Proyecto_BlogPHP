<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hidden Sound Atlas</title>
    <link rel="stylesheet" href="/Proyecto_BlogPHP/public/css/style.css">
</head>

<body class="auth-body">
        <canvas id="blueRoomCanvas"></canvas>

        <div class="stars-layer">
    <div class="star" style="top:20%; left: 25%; animation-delay:0s;"></div>
    <div class="star" style="top:60%; left: 45%; animation-delay:3s;"></div>
    <div class="star" style="top:35%; left: 70%; animation-delay:6s;"></div>
    <div class="star" style="top:80%; left: 10%; animation-delay:9s;"></div>
    </div>

<div class="waves-layer"></div>


<div class="home-public-wrapper">

    <!-- CUADRO CENTRAL -->
    <div class="auth-container home-welcome-box">

        <div class="welcome-header">
            <img src="/Proyecto_BlogPHP/public/img_posts/logo_hsa.png"
                 alt="Hidden Sound Atlas Logo"
                 class="hsa-logo">

            <div class="welcome-titles">
                <h1>Hidden Sound Atlas</h1>
                <h2>Mapa Sonoro · Zona Pública</h2>
            </div>
        </div>

        <p class="welcome-text">
            Bienvenido al portal. Aquí descubrirás sonidos ocultos, artistas alternativos 
            y rincones oscuros del panorama musical.
        </p>

        <p class="welcome-text">
            Una invitación a explorar mapas sonoros que no aparecen en ningún algoritmo.
        </p>

        <div class="home-welcome-buttons">
            <a href="/Proyecto_BlogPHP/public/?controller=auth&action=loginForm" class="welcome-btn">
                Entrar en The Blue Room
            </a>

            <a href="/Proyecto_BlogPHP/public/?controller=register&action=registerForm" class="welcome-btn">
                Crear cuenta nueva
            </a>
        </div>

        <p class="welcome-footnote">
            The Blue Room es la zona privada donde podrás leer los posts completos.
        </p>

    </div>


    <!-- LISTA DE POSTS -->
    <section class="home-posts-section">

        <h3 class="section-title">Últimos descubrimientos del mapa sonoro</h3>

        <?php if (!empty($publicPosts)) : ?>

            <?php foreach ($publicPosts as $post): ?>
                <article class="home-post-card">

                    <?php if (!empty($post['image'])) : ?>
                        <img src="/Proyecto_BlogPHP/public<?= htmlspecialchars($post['image']) ?>" 
                             alt="cover"
                             class="home-post-image">
                    <?php endif; ?>

                    <div class="home-post-content">

                        <h4 class="post-title">
                            <?= htmlspecialchars($post['title']) ?>
                        </h4>

                        <?php if (!empty($post['subtitle'])) : ?>
                            <p class="post-subtitle">
                                <em><?= htmlspecialchars($post['subtitle']) ?></em>
                            </p>
                        <?php endif; ?>

                        <p class="post-extract">
                            <?= htmlspecialchars(mb_substr($post['content'], 0, 150)) ?>...
                        </p>

                        <a href="/Proyecto_BlogPHP/public/?controller=auth&action=loginForm"
                           class="post-readmore">
                            Seguir leyendo →
                        </a>

                    </div>

                </article>
            <?php endforeach; ?>

        <?php else: ?>

            <p class="no-posts-msg">
                Aún no hay descubrimientos publicados.
            </p>

        <?php endif; ?>

    </section>

    <!-- FOOTER -->
    <footer class="public-footer">
    © <?= date("Y") ?> Hidden Sound Atlas — The Blue Room | Explorando lo oculto    </footer>

</div>
<script src="/Proyecto_BlogPHP/public/js/blueRoomAurora.js"></script>

</body>
</html>
