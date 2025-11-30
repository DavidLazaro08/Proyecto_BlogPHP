<?php  
// Pantalla de inicio de sesión del proyecto Hidden Sound Atlas.
// Aquí los usuarios acceden a su cuenta antes de entrar en The Blue Room.
// Si hay problemas con el login, mostramos el aviso correspondiente.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hidden Sound Atlas - Access</title>
    <link rel="stylesheet" href="/Proyecto_BlogPHP/public/css/style.css">
</head>
<body class="auth-body">
        <canvas id="blueRoomCanvas"></canvas>

    <div class="auth-container">
        <h1>Hidden Sound Atlas</h1>
        <h2>The Blue Room Access</h2>

        <?php if (isset($error)) : ?>
            <p class="auth-error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="/Proyecto_BlogPHP/public/?controller=auth&action=login" class="auth-form">
            <label for="email">Correo</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Entrar en The Blue Room</button>
        </form>

        <p class="auth-footnote">
            ¿No tienes cuenta?  
            <a href="/Proyecto_BlogPHP/public/?controller=register&action=registerForm" class="auth-link">
                Crear cuenta
            </a>
        </p>

        <p class="auth-footnote">
            Acceso privado a The Blue Room. Regístrate para entrar y participar.
        </p>

    </div>
<script src="/Proyecto_BlogPHP/public/js/blueRoomAurora.js"></script>

</body>
</html>
