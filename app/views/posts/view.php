<article class="post-full-wrapper">

    <div class="post-full-card">

        <!-- TÍTULO -->
        <h1 class="post-full-title">
            <?= htmlspecialchars($post['title']) ?>
        </h1>

        <!-- SUBTÍTULO -->
        <?php if (!empty($post['subtitle'])): ?>
            <h3 class="post-full-subtitle">
                <?= htmlspecialchars($post['subtitle']) ?>
            </h3>
        <?php endif; ?>
                
        <!-- AUTOR -->
        <p class="post-full-author" style="display:flex; align-items:center; gap:8px; justify-content:center; margin-top:20px; opacity:0.85;">
        <img src="/Proyecto_BlogPHP/public/avatars/<?= htmlspecialchars($post['avatar']) ?>"
            style="width:32px; height:32px; border-radius:50%; object-fit:cover; border:1px solid rgba(120,160,255,0.35);">
        <span>Escrito por <strong><?= htmlspecialchars($post['username']) ?></strong></span>
        </p>

        <!-- IMAGEN -->
        <?php if (!empty($post['image'])): ?>
            <div class="post-full-image-wrapper">
                <img src="/Proyecto_BlogPHP/public<?= htmlspecialchars($post['image']) ?>"
                     class="post-full-image"
                     alt="Imagen del post">
            </div>
        <?php endif; ?>

        <!-- VISUALIZACIONES -->
        <p class="post-full-views">
            👁 <?= $post['views'] ?> visualizaciones
        </p>
        
        <!-- CONTENIDO -->
        <div class="post-full-content">
            <?= nl2br(htmlspecialchars($post['content'])) ?>
        </div>

    </div>

    <!-- ENLACE VOLVER -->
    <p class="post-back-link">
        <a href="/Proyecto_BlogPHP/public/?controller=posts&action=index">
            ← Volver al archivo completo
        </a>
    </p>

</article>
