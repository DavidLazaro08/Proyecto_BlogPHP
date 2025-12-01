<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>The Blue Room — Hidden Sound Atlas</title>
    <link rel="stylesheet" href="/Proyecto_BlogPHP/public/css/style.css">

</head>

<body class="private-body">
    <canvas id="blueRoomCanvas"></canvas>

<div class="stars-layer">
    <!-- Micro (polvo finísimo) -->
    <div class="star micro"  style="top:12%; left:18%;"></div>
    <div class="star micro"  style="top:55%; left:72%;"></div>
    <div class="star micro"  style="top:78%; left:30%;"></div>

    <!-- Normales -->
    <div class="star normal" style="top:25%; left:40%;"></div>
    <div class="star normal" style="top:45%; left:15%;"></div>
    <div class="star normal" style="top:70%; left:65%;"></div>

    <!-- Glow (difusas) -->
    <div class="star glow"   style="top:32%; left:62%;"></div>
    <div class="star glow"   style="top:82%; left:22%;"></div>
</div>

<div class="waves-layer"></div>
<div class="grain-layer"></div>


<?php

// ==========================================================
// AVATAR MINI — NORMALIZADO COMO EN EL PERFIL
// ==========================================================

// Avatar crudo (puede venir NULL o vacío)
$rawAvatar = $_SESSION['avatar'] ?? null;

// Si no hay avatar, usar el default
$avatar = $rawAvatar ?: '/avatars/default.jpg';

// Normalizar siempre a ruta /avatars/xxx
if (strpos($avatar, '/avatars/') !== 0) {
    $avatar = '/avatars/' . ltrim($avatar, '/');
}

// Ruta absoluta pública para mostrar la imagen
$avatarPath = "/Proyecto_BlogPHP/public" . $avatar;
?>


<header class="private-header-bar">
    <div class="header-inner">

        <!-- IZQUIERDA -->
        <div class="header-left">
            <img src="/Proyecto_BlogPHP/public/img_posts/logo_hsaC.png"
                 alt="HSA" class="header-logo">
        </div>

        <!-- CENTRO -->
        <div class="header-center">
            <h1 class="header-title">Hidden Sound Atlas</h1>
            <p class="header-subtitle">THE BLUE ROOM</p>
        </div>

        <!-- DERECHA — ÁREA DE USUARIO -->
        <nav class="header-user-area">

            <?php if (!empty($_SESSION['user_id'])): ?>

                <div class="user-wrapper">

            <!-- Icono hamburguesa -->
            <div class="user-menu-icon" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <!-- Burbujita del usuario -->
            <div class="user-bubble">
                <img src="<?= $avatarPath ?>" class="user-avatar-mini">
                <span class="user-status-dot"></span>
                <span class="user-name-mini">
                    <?= htmlspecialchars($_SESSION['username']) ?>
                </span>
            </div>

            <!-- Menú dropdown (DEBE estar aquí mismo, sin nada entre medias) -->
            <div class="user-dropdown">

                <a href="/Proyecto_BlogPHP/public/?controller=posts&action=index">Inicio</a>

                <a href="/Proyecto_BlogPHP/public/?controller=users&action=profile">
                    Mi perfil
                </a>

                <?php if ($_SESSION['role'] === 'editor' || $_SESSION['role'] === 'admin'): ?>
                    <a href="/Proyecto_BlogPHP/public/?controller=posts&action=createForm">
                        Nuevo post
                    </a>
                <?php endif; ?>

                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="/Proyecto_BlogPHP/public/?controller=panel&action=dashboard">
                        Panel de moderación
                    </a>

                    <a href="/Proyecto_BlogPHP/public/?controller=panel&action=users">
                        Gestión de usuarios
                    </a>
                <?php endif; ?>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="/Proyecto_BlogPHP/public/?controller=panel&action=editorRequests">
                    Solicitudes de editor
                </a>
                <?php endif; ?>

                <?php if ($_SESSION['role'] === 'user'): ?>
                    <a href="/Proyecto_BlogPHP/public/?controller=users&action=requestEditor">
                        Ser editor
                    </a>
                <?php endif; ?>

                <a href="/Proyecto_BlogPHP/public/?controller=auth&action=logout"
                style="color:#ff8c8c;">
                    Salir
                </a>
            </div>

        </div>

        <!-- BOTÓN DE SONIDO (fuera del user-wrapper) -->
        <div class="sound-toggle" id="soundToggle">🎧</div>

        <!-- AUDIO AMBIENT -->
        <audio id="ambientAudio" loop>
            <source src="/assets/audio/ambient-blue-room.mp3" type="audio/mp3">
        </audio>


            <?php else: ?>

                <a href="/Proyecto_BlogPHP/public/?controller=auth&action=loginForm">Entrar</a>
                <a href="/Proyecto_BlogPHP/public/?controller=auth&action=registerForm">Registro</a>

            <?php endif; ?>

        </nav>
    </div>
</header>

<!-- CONTENIDO -->
<main class="private-main">
    <?= $content ?? "" ?>
</main>

<!-- FOOTER -->
<footer class="public-footer">
    © <?= date("Y") ?> Hidden Sound Atlas — The Blue Room | Explorando lo oculto
</footer>

<script src="/Proyecto_BlogPHP/public/js/header-auto-hide.js"></script>
<script src="/Proyecto_BlogPHP/public/js/user-menu.js"></script>
<script src="/Proyecto_BlogPHP/public/js/avatar-upload.js"></script>
<script src="/Proyecto_BlogPHP/public/js/blueRoomAurora.js"></script>
<script src="/public/js/blue-room-audio.js"></script>


</body>

</html>
