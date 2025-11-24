<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hidden Sound Atlas</title>
    <link rel="stylesheet" href="/Proyecto_BlogPHP/public/css/style.css">
</head>

<body class="auth-body">

    <div class="auth-container">

        <h1>Hidden Sound Atlas</h1>
        <h2>Mapa Sonoro · Zona Pública</h2>

        <p class="auth-footnote" style="margin-top:10px;">
            Bienvenido al portal. Aquí descubrirás sonidos ocultos,
            artistas alternativos y rincones oscuros del panorama musical.
        </p>

        <div style="margin-top: 25px; display:flex; flex-direction:column; gap:12px;">
            <a href="/Proyecto_BlogPHP/public/?controller=auth&action=loginForm" 
               class="auth-link" 
               style="font-size:1.1rem; text-align:center;">
                Entrar en The Blue Room
            </a>

            <a href="/Proyecto_BlogPHP/public/?controller=register&action=registerForm" 
               class="auth-link" 
               style="font-size:1.1rem; text-align:center;">
                Crear cuenta nueva
            </a>
        </div>

        <p class="auth-footnote" style="margin-top:25px;">
            The Blue Room es la zona privada donde podrás leer los posts completos.
        </p>

    </div>

</body>
</html>
