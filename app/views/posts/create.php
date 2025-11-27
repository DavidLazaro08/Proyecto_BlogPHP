<h2 style="color:#8fbaff; text-align:center;">Crear nueva publicación</h2>

<form method="POST" enctype="multipart/form-data"
      action="/Proyecto_BlogPHP/public/?controller=posts&action=store"
      class="auth-form">

    <label>Título</label>
    <input type="text" name="title" required>

    <label>Subtítulo</label>
    <input type="text" name="subtitle">

    <label>Contenido</label>
    <textarea name="content" rows="8" style="padding:10px; background:#111; color:#e0e0e0; border:1px solid #333;"></textarea>

    <label>Imagen (opcional)</label>
    <input type="file" name="image">

    <button type="submit">Publicar</button>
</form>
