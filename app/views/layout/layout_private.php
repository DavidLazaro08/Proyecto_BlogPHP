<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>The Blue Room — Hidden Sound Atlas</title>
    <link rel="stylesheet" href="/Proyecto_BlogPHP/public/css/style.css">
    
</head>

<body class="private-body">

<header class="private-header-bar">
    <div class="header-inner">

        <div class="header-left">
            <img src="/Proyecto_BlogPHP/public/img_posts/logo_hsaC.png" alt="HSA" class="header-logo">
        </div>

        <div class="header-center">
            <h1 class="header-title">Hidden Sound Atlas</h1>
            <p class="header-subtitle">THE BLUE ROOM</p>
        </div>

        <nav class="header-right">
            <a href="/Proyecto_BlogPHP/public/?controller=posts&action=index">Inicio</a>
            <a href="/Proyecto_BlogPHP/public/?controller=posts&action=createForm">Nuevo post</a>
            <a href="/Proyecto_BlogPHP/public/?controller=auth&action=logout">Salir</a>
        </nav>

    </div>
</header>

<main class="private-main">
    <?= $content ?>
</main>

<footer class="private-footer">
    © <?= date("Y") ?> Hidden Sound Atlas — The Blue Room
</footer>
<script src="/Proyecto_BlogPHP/public/js/header-auto-hide.js"></script>

</body>
</html>
