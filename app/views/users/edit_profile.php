<div class="edit-header">
    <a href="javascript:history.back()" class="btn-back">← Volver</a>

    <h2 class="profile-title">Editar mis datos</h2>
</div>

<p class="profile-subtitle">Modifica tu nombre y correo electrónico.</p>


<form action="/Proyecto_BlogPHP/public/?controller=users&action=updateProfile"
      method="POST"
      class="edit-form">

    <label>Nombre de usuario</label>
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

    <label>Correo electrónico</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

    <button type="submit" class="btn-big">Guardar cambios</button>
</form>