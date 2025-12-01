<?php
// Normalización de avatar
$avatar = $post['avatar'] ?? "";

if (str_starts_with($avatar, "/avatars/")) {
    $avatar = substr($avatar, strlen("/avatars/"));
}

if (!$avatar) {
    $avatar = "default.jpg";
}
?>

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
        <div class="post-full-author">
            <img src="/Proyecto_BlogPHP/public/avatars/<?= htmlspecialchars($avatar) ?>"
                 class="post-full-avatar">
            <span>
                Escrito por <strong><?= htmlspecialchars($post['username']) ?></strong>
            </span>
        </div>

        <!-- IMAGEN PRINCIPAL -->
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

    <!-- VOLVER -->
    <p class="post-back-link">
        <a href="/Proyecto_BlogPHP/public/?controller=posts&action=index">
            ← Volver al archivo completo
        </a>
    </p>

</article>
