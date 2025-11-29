<h2 style="color:#8fbaff; text-align:center;">Editar publicación</h2>

<form method="POST" enctype="multipart/form-data"
      action="/Proyecto_BlogPHP/public/?controller=posts&action=update&id=<?= $post['id'] ?>"
      class="auth-form">

    <label>Título</label>
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>

    <label>Subtítulo</label>
    <input type="text" name="subtitle" value="<?= htmlspecialchars($post['subtitle']) ?>">

    <label>Contenido</label>
    <textarea name="content" rows="8"><?= htmlspecialchars($post['content']) ?></textarea>

    <label>Cambiar imagen</label>
    <input type="file" name="image">

    <button type="submit">Guardar cambios</button>
</form>
