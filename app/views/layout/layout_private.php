<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>The Blue Room — Hidden Sound Atlas</title>
    <link rel="stylesheet" href="/Proyecto_BlogPHP/public/css/style.css">
</head>

<body class="private-body">

<!-- CANVAS Y CAPAS DINÁMICAS -->
<canvas id="blueRoomCanvas"></canvas>

<div class="stars-layer">
    <div class="star micro"  style="top:12%; left:18%;"></div>
    <div class="star micro"  style="top:55%; left:72%;"></div>
    <div class="star micro"  style="top:78%; left:30%;"></div>

    <div class="star normal" style="top:25%; left:40%;"></div>
    <div class="star normal" style="top:45%; left:15%;"></div>
    <div class="star normal" style="top:70%; left:65%;"></div>

    <div class="star glow"   style="top:32%; left:62%;"></div>
    <div class="star glow"   style="top:82%; left:22%;"></div>
</div>

<div class="waves-layer"></div>
<div class="grain-layer"></div>

<?php
$rawAvatar = $_SESSION['avatar'] ?? null;
$avatar = $rawAvatar ?: '/avatars/default.jpg';
if (strpos($avatar, '/avatars/') !== 0) {
    $avatar = '/avatars/' . ltrim($avatar, '/');
}
$avatarPath = "/Proyecto_BlogPHP/public" . $avatar;
?>

<header class="private-header-bar">
    <div class="header-inner">

        <div class="header-left">
            <img src="/Proyecto_BlogPHP/public/img_posts/logo_hsaC.png"
                 alt="HSA" class="header-logo">
        </div>

        <div class="header-center">
            <h1 class="header-title">Hidden Sound Atlas</h1>
            <p class="header-subtitle">THE BLUE ROOM</p>
        </div>

        <nav class="header-user-area">
        <?php if (!empty($_SESSION['user_id'])): ?>

            <div class="user-wrapper">

                <div class="user-menu-icon" id="menuToggle">
                    <span></span><span></span><span></span>
                </div>

                <div class="user-bubble">
                    <img src="<?= $avatarPath ?>" class="user-avatar-mini">
                    <span class="user-status-dot"></span>
                    <span class="user-name-mini">
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    </span>
                </div>

                <div class="user-dropdown">
                    <a href="/Proyecto_BlogPHP/public/?controller=posts&action=index">Inicio</a>
                    <a href="/Proyecto_BlogPHP/public/?controller=users&action=profile">Mi perfil</a>

                    <?php if ($_SESSION['role'] === 'editor' || $_SESSION['role'] === 'admin'): ?>
                        <a href="/Proyecto_BlogPHP/public/?controller=posts&action=createForm">Nuevo post</a>
                    <?php endif; ?>

                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a href="/Proyecto_BlogPHP/public/?controller=panel&action=dashboard">Panel de moderación</a>
                        <a href="/Proyecto_BlogPHP/public/?controller=panel&action=users">Gestión de usuarios</a>
                        <a href="/Proyecto_BlogPHP/public/?controller=panel&action=editorRequests">Solicitudes de editor</a>
                    <?php endif; ?>

                    <?php if ($_SESSION['role'] === 'user'): ?>
                        <a href="/Proyecto_BlogPHP/public/?controller=users&action=requestEditor">Ser editor</a>
                    <?php endif; ?>

                    <a href="/Proyecto_BlogPHP/public/?controller=auth&action=logout" style="color:#ff8c8c;">
                        Salir
                    </a>
                </div>

            </div>

            <!-- BOTÓN DE SONIDO -->
            <div class="sound-toggle" id="soundToggle">🎧</div>

        <?php else: ?>

            <a href="/Proyecto_BlogPHP/public/?controller=auth&action=loginForm">Entrar</a>
            <a href="/Proyecto_BlogPHP/public/?controller=auth&action=registerForm">Registro</a>

        <?php endif; ?>
        </nav>
    </div>
</header>

<main class="private-main">
    <?= $content ?? "" ?>
</main>

<footer class="public-footer">
    © <?= date("Y") ?> Hidden Sound Atlas — The Blue Room | Explorando lo oculto
</footer>

<!-- AUDIO GLOBAL -->
<audio id="ambientAudio" loop preload="auto">
    <source src="/Proyecto_BlogPHP/public/audio/sirena.mp3" type="audio/mp3">
</audio>

<!-- OVERLAY SONIDO -->
<div id="soundIntroOverlay" class="sound-intro-overlay">
    <div class="sound-intro-box">
        <h2>🌌 Bienvenido a The Blue Room</h2>
        <p>Activa tus sentidos. Déjate envolver por la atmósfera sonora.</p>
    </div>
</div>

<!-- SCRIPTS -->
<script src="/Proyecto_BlogPHP/public/js/header-auto-hide.js"></script>
<script src="/Proyecto_BlogPHP/public/js/user-menu.js"></script>
<script src="/Proyecto_BlogPHP/public/js/avatar-upload.js"></script>
<script src="/Proyecto_BlogPHP/public/js/blueRoomAurora.js"></script>
<script src="/Proyecto_BlogPHP/public/js/blue-room-audio.js"></script>

</body>
</html>
