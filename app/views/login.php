<?php 
// Pantalla de inicio de sesión del proyecto Hidden Sound Atlas.
// Aquí los usuarios acceden a su cuenta antes de entrar a The Blue Room.
// Mostramos aviso si hay problemas con el login.
?>

<?php if (isset($debug) && $debug === true): ?>
    <pre style="background:#111;color:#0f0;padding:10px;">
    DEBUG LOGIN -----------------------
    EMAIL RECIBIDO:
    <?php var_dump($email ?? null); ?>

    PASSWORD RECIBIDA (raw):
    <?php var_dump($password ?? null); ?>

    USUARIO ENCONTRADO EN BD:
    <?php var_dump($user ?? null); ?>

    VERIFICACIÓN PASSWORD:
    <?php var_dump($passwordCheck ?? null); ?>

    -----------------------------------
    </pre>
<?php endif; ?>

<?php if (isset($error)) : ?>
    <p style="color: red;"><?= $error ?></p>
<?php endif; ?>

<form method="POST" action="/Proyecto_BlogPHP/public/?controller=auth&action=login" autocomplete="off">
    
    <label for="email">Correo:</label>
    <input type="email" name="email" autocomplete="off" required>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" autocomplete="new-password" required>

    <button type="submit">Iniciar sesión</button>
</form>
