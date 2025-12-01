<!-- FORMULARIO BLUE ROOM -->
<div class="br-post-form-wrapper">

    <div class="br-post-form-card">

        <h2 class="br-post-title">Crear nueva publicación</h2>

        <form method="POST"
              enctype="multipart/form-data"
              action="/Proyecto_BlogPHP/public/?controller=posts&action=store">

            <label>Título</label>
            <input type="text" name="title" required class="br-input">

            <label>Subtítulo</label>
            <input type="text" name="subtitle" class="br-input">

            <label>Contenido</label>
            <textarea name="content" class="br-textarea"></textarea>

            <label>Imagen</label>
            <input type="file" name="image" class="br-input">

            <label>Visibilidad</label>
            <select name="visibility" required class="br-select">
                <option value="public">Público</option>
                <option value="private">Privado</option>
            </select>

            <button type="submit" class="br-submit-btn">
                Publicar
            </button>

        </form>

    </div>

    <!-- BOTÓN VOLVER ARRIBA -->
    <div class="mod-header"
         style="max-width:1200px; margin:25px auto 10px; padding:0 20px;">

        <a href="/Proyecto_BlogPHP/public/?controller=posts&action=index"
           class="btn-back">
            ← Volver
        </a>

    </div>

</div>
