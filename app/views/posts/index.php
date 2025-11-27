<h2 class="posts-title">Archivo completo del mapa sonoro</h2>
<p class="posts-subtitle">Explora todas las publicaciones del atlas sonoro.</p>

<?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'editor'): ?>
    <a href="/Proyecto_BlogPHP/public/?controller=posts&action=createForm" class="btn-new-post-center">
        + Crear nuevo post
    </a>
<?php endif; ?>


<div class="posts-grid">
    <?php foreach ($posts as $post): ?>
        <article class="post-card">

            <div class="post-card-image-wrap">
                <?php if (!empty($post['image'])): ?>
                    <img src="/Proyecto_BlogPHP/public<?= htmlspecialchars($post['image']) ?>" class="post-card-image">
                <?php endif; ?>
            </div>

            <div class="post-card-body">
                <h3 class="post-card-title"><?= htmlspecialchars($post['title']) ?></h3>

                <?php if (!empty($post['subtitle'])): ?>
                    <p class="post-card-subtitle">
                        <em><?= htmlspecialchars($post['subtitle']) ?></em>
                    </p>
                <?php endif; ?>

                <p class="post-card-excerpt">
                    <?= htmlspecialchars(mb_substr($post['content'], 0, 110)) ?>...
                </p>

                <div class="post-card-footer">
                    <div class="post-card-author">
                        <img src="/Proyecto_BlogPHP/public/avatars/<?= htmlspecialchars($post['avatar']) ?>"
                             class="post-card-avatar">
                        <span><?= htmlspecialchars($post['username']) ?></span>
                    </div>

                    <a class="post-card-link"
                       href="/Proyecto_BlogPHP/public/?controller=posts&action=view&id=<?= $post['id'] ?>">
                        Leer más →
                    </a>
                </div>
            </div>

        </article>
    <?php endforeach; ?>
</div>
