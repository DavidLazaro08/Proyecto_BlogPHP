<h2 class="posts-title" style="margin-bottom:25px;">
    Moderación completa de publicaciones
</h2>

<?php foreach ($posts as $post): ?>

    <article class="moderation-card">

        <!-- Imagen -->
        <?php if (!empty($post['image'])): ?>
            <img src="/Proyecto_BlogPHP/public<?= htmlspecialchars($post['image']) ?>"
                 class="moderation-cover">
        <?php endif; ?>

        <!-- Contenido -->
        <div class="moderation-body">

            <h3 class="moderation-title"><?= htmlspecialchars($post['title']) ?></h3>

            <?php if (!empty($post['subtitle'])): ?>
                <p class="moderation-subtitle">
                    <em><?= htmlspecialchars($post['subtitle']) ?></em>
                </p>
            <?php endif; ?>

            <p class="moderation-excerpt">
                <?= htmlspecialchars(mb_substr($post['content'], 0, 150)) ?>...
            </p>

            <p class="moderation-author">
                Autor: <strong><?= htmlspecialchars($post['username']) ?></strong>
            </p>

            <!-- ESTADO -->
            <?php
                $status = trim(strtolower($post['status']));
                $badgeClass = "status-unknown";

                switch ($status) {
                    case 'approved': $badgeClass = "status-approved"; break;
                    case 'pending':  $badgeClass = "status-pending";  break;
                    case 'rejected': $badgeClass = "status-rejected"; break;
                    case 'draft':    $badgeClass = "status-draft";    break;
                }
            ?>

            <span class="status-badge <?= $badgeClass ?>">
                <?= htmlspecialchars(ucfirst($status)) ?>
            </span>

        </div>

        <!-- Acciones -->
        <div class="moderation-actions">

            <?php if ($status !== 'approved'): ?>
                <a href="/Proyecto_BlogPHP/public/?controller=panel&action=approve&id=<?= $post['id'] ?>"
                   class="btn-mod btn-approve">
                    ✓ Aprobar
                </a>
            <?php endif; ?>

            <?php if ($status !== 'rejected'): ?>
                <a href="/Proyecto_BlogPHP/public/?controller=panel&action=reject&id=<?= $post['id'] ?>"
                   class="btn-mod btn-reject">
                    ✖ Rechazar
                </a>
            <?php endif; ?>

            <a href="/Proyecto_BlogPHP/public/?controller=panel&action=delete&id=<?= $post['id'] ?>"
               class="btn-mod btn-delete">
                🗑 Borrar
            </a>

        </div>

    </article>

<?php endforeach; ?>
