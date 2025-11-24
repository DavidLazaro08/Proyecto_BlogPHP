<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hidden Sound Atlas</title>

    <link rel="stylesheet" href="/Proyecto_BlogPHP/public/css/style.css">
</head>

<body>

    <header>
        <h1>Hidden Sound Atlas</h1>
        <nav>
            <a href="/Proyecto_BlogPHP/public/?controller=home&action=index">Inicio</a>
            <a href="/Proyecto_BlogPHP/public/?controller=auth&action=logout">Salir</a>
        </nav>
    </header>

    <main>
        <?= $content ?? '' ?>
    </main>

    <footer>
        <p>© <?= date("Y") ?> Hidden Sound Atlas — The Blue Room</p>
    </footer>

</body>
</html>
