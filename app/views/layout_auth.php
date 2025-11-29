<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>The Blue Room — Hidden Sound Atlas</title>
    <link rel="stylesheet" href="/Proyecto_BlogPHP/public/css/style.css">
</head>

<body class="private-body">

    <!-- NAV superior -->
    <header class="private-header">
        <h1>The Blue Room</h1>

        <nav class="private-nav">
            <a href="/Proyecto_BlogPHP/public/?controller=posts&action=index">Inicio</a>
            <a href="/Proyecto_BlogPHP/public/?controller=posts&action=createForm">Nuevo post</a>
            <a href="/Proyecto_BlogPHP/public/?controller=auth&action=logout">Salir</a>
        </nav>
    </header>

    <main class="private-main">
        <?= $content ?> 
    </main>

</body>
</html>
