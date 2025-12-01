<?php
// Vista sólo para ADMIN: edición de cualquier usuario
?>

<div class="edit-header">
    <a href="javascript:history.back()" class="btn-back">← Volver</a>

    <h2 class="profile-title">Editar usuario</h2>
</div>

<p class="profile-subtitle">
    Modifica el nombre, correo y rol de este usuario.
</p>

<form action="/Proyecto_BlogPHP/public/?controller=panel&action=updateUser"
      method="POST"
      class="edit-form">

    <!-- ID oculto del usuario -->
    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <label>Nombre de usuario</label>
    <input type="text"
           name="username"
           value="<?= htmlspecialchars($user['username']) ?>"
           required>

    <label>Correo electrónico</label>
    <input type="email"
           name="email"
           value="<?= htmlspecialchars($user['email']) ?>"
           required>

    <label>Rol</label>
    <select name="role" class="edit-select">
        <option value="user"   <?= $user['role'] === 'user'   ? 'selected' : '' ?>>Usuario</option>
        <option value="editor" <?= $user['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
        <option value="admin"  <?= $user['role'] === 'admin'  ? 'selected' : '' ?>>Administrador</option>
    </select>

    <button type="submit" class="btn-big">
        Guardar cambios
    </button>
</form>
