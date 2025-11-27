<div class="private-container">

    <h2 class="private-title">Archivo completo del mapa sonoro</h2>
    <p class="private-subtitle">Explora todas las publicaciones del proyecto Hidden Sound Atlas.</p>

    <p style="text-align:center; margin-bottom:35px;">
        <a href="/Proyecto_BlogPHP/public/?controller=posts&action=createForm"
           class="btn-new-post">
           + Crear nueva publicación
        </a>
    </p>

    <div class="posts-grid">

        <?php foreach ($posts as $post): ?>

            <article class="post-card">

                <?php if (!empty($post['image'])): ?>
                    <img src="/Proyecto_BlogPHP/public<?= htmlspecialchars($post['image']) ?>"
                         class="post-card-thumb">
                <?php endif; ?>

                <div class="post-card-body">

                    <h3 class="post-card-title">
                        <?= htmlspecialchars($post['title']) ?>
                    </h3>

                    <?php if (!empty($post['subtitle'])): ?>
                        <p class="post-card-sub">
                            <em><?= htmlspecialchars($post['subtitle']) ?></em>
                        </p>
                    <?php endif; ?>

                    <p class="post-card-extract">
                        <?= htmlspecialchars(mb_substr($post['content'], 0, 150)) ?>...
                    </p>

                    <a href="/Proyecto_BlogPHP/public/?controller=posts&action=view&id=<?= $post['id'] ?>"
                       class="post-card-readmore">
                       Leer post completo →
                    </a>

                </div>

            </article>

        <?php endforeach; ?>

    </div>
</div>
