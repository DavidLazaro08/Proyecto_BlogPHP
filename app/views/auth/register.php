<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hidden Sound Atlas - Registro</title>
    <link rel="stylesheet" href="/Proyecto_BlogPHP/public/css/style.css">
</head>
<body class="auth-body">

    <div class="auth-container">
        
        <h1>Hidden Sound Atlas</h1>
        <h2>Crear cuenta</h2>

        <?php if (isset($error)) : ?>
            <p class="auth-error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="/Proyecto_BlogPHP/public/?controller=register&action=register" class="auth-form">
            
            <label for="username">Nombre de usuario</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>

            <label for="password2">Repite la contraseña</label>
            <input type="password" name="password2" id="password2" required>

            <button type="submit">Crear cuenta</button>
        </form>

        <p class="auth-footnote">
            ¿Ya tienes cuenta?  
            <a href="/Proyecto_BlogPHP/public/?controller=auth&action=loginForm" class="auth-link">
                Inicia sesión aquí
            </a>
        </p>

    </div>

</body>
</html>
