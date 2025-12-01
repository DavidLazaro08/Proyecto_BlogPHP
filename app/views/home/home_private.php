<div class="private-container">

    <h2 class="private-title">The Blue Room</h2>
    <p class="private-subtitle">Acceso exclusivo al archivo completo del mapa sonoro.</p>

    <?php if ($_SESSION['role'] === "editor" || $_SESSION['role'] === "admin"): ?>
        <a href="/Proyecto_BlogPHP/public/?controller=post&action=createForm"
           class="btn-new-post">
           + Crear nueva publicación
        </a>
    <?php endif; ?>

    <?php foreach ($posts as $post): ?>
        <article class="private-post-card">

            <?php if (!empty($post['image'])): ?>
                <img src="/Proyecto_BlogPHP/public<?= htmlspecialchars($post['image']) ?>"
                     class="private-post-thumb">
            <?php endif; ?>

            <div class="private-post-info">
                <h3><?= htmlspecialchars($post['title']) ?></h3>

                <p class="private-sub">
                    <?= htmlspecialchars($post['subtitle']) ?>
                </p>

                <a href="/Proyecto_BlogPHP/public/?controller=post&action=view&slug=<?= $post['slug'] ?>"
                   class="private-readmore">
                    Leer post completo →
                </a>
            </div>

        </article>
    <?php endforeach; ?>

</div>
