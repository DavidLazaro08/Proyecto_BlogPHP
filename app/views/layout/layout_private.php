<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>The Blue Room — Hidden Sound Atlas</title>
    <link rel="stylesheet" href="/Proyecto_BlogPHP/public/css/style.css">
</head>

<body class="private-body">

<?php
// ==========================================================
// AVATAR SEGÚN ROL — FIX RUTA
// ==========================================================

// Avatar por defecto
$avatarFile = "/avatars/default.png";

// Avatar admin
if (($_SESSION['role'] ?? '') === 'admin') {

    $avatarFile = "/avatars/Admin.jpg";

} else if (!empty($_SESSION['avatar'])) {

    // Si el nombre NO contiene "/" significa que solo es "DavidLazaro08.jpg"
    // → le añadimos "/avatars/"
    if (strpos($_SESSION['avatar'], "/") === false) {
        $avatarFile = "/avatars/" . $_SESSION['avatar'];
    } else {
        $avatarFile = $_SESSION['avatar'];
    }
}

// Ruta final completa
$avatarPath = "/Proyecto_BlogPHP/public" . $avatarFile;

?>

<header class="private-header-bar">
    <div class="header-inner">

        <!-- LOGO IZQUIERDA -->
        <div class="header-left">
            <img src="/Proyecto_BlogPHP/public/img_posts/logo_hsaC.png" alt="HSA" class="header-logo">
        </div>

        <!-- TÍTULO CENTRAL -->
        <div class="header-center">
            <h1 class="header-title">Hidden Sound Atlas</h1>
            <p class="header-subtitle">THE BLUE ROOM</p>
        </div>

        <!-- ÁREA DE USUARIO -->
        <nav class="header-user-area">

            <?php if (!empty($_SESSION['user_id'])): ?>

                <div class="user-wrapper">

                    <!-- ICONO HAMBURGUESA -->
                    <div class="user-menu-icon" id="menuToggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <!-- BURBUJA DEL USUARIO -->
                    <div class="user-bubble">
                        <img src="<?= $avatarPath ?>" class="user-avatar-mini">

                        <span class="user-status-dot"></span>

                        <span class="user-name-mini">
                            <?= htmlspecialchars($_SESSION['username']) ?>
                        </span>
                    </div>

                    <!-- MENÚ DESPLEGABLE -->
                    <div class="user-dropdown">
                        <a href="/Proyecto_BlogPHP/public/?controller=posts&action=index">Inicio</a>

                        <?php if ($_SESSION['role'] === 'editor' || $_SESSION['role'] === 'admin'): ?>
                            <a href="/Proyecto_BlogPHP/public/?controller=posts&action=createForm">Nuevo post</a>
                        <?php endif; ?>

                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <a href="/Proyecto_BlogPHP/public/?controller=panel&action=dashboard">Panel de moderación</a>
                            <a href="/Proyecto_BlogPHP/public/?controller=panel&action=users">Gestión de usuarios</a>
                        <?php endif; ?>


                        <a href="/Proyecto_BlogPHP/public/?controller=panel&action=profile">Mi perfil</a>

                        <?php if ($_SESSION['role'] === 'user'): ?>
                            <a href="/Proyecto_BlogPHP/public/?controller=panel&action=requestEditor">Ser editor</a>
                        <?php endif; ?>

                        <a href="/Proyecto_BlogPHP/public/?controller=auth&action=logout" style="color:#ff8c8c;">
                            Salir
                        </a>
                    </div>

                </div>

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

<script src="/Proyecto_BlogPHP/public/js/header-auto-hide.js"></script>
<script src="/Proyecto_BlogPHP/public/js/user-menu.js"></script>

</body>
</html>
