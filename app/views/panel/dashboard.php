<div class="mod-header">
    <a href="javascript:history.back()" class="btn-back">← Volver</a>

    <h2 class="posts-title">
        Moderación completa de publicaciones
    </h2>
</div>

<?php foreach ($posts as $post): ?>

    <?php
        // Normalizar estado
        $status = strtolower(trim($post['status']));

        // Traducción visible
        $statusText = [
            'approved' => 'Aprobado',
            'pending'  => 'Pendiente',
            'rejected' => 'Rechazado',
            'draft'    => 'Borrador'
        ];

        $displayText = $statusText[$status] ?? 'Desconocido';

        // Clase visual correspondiente
        switch ($status) {
            case 'approved': $badgeClass = "status-approved"; break;
            case 'pending':  $badgeClass = "status-pending";  break;
            case 'rejected': $badgeClass = "status-rejected"; break;
            case 'draft':    $badgeClass = "status-draft";    break;
            default:         $badgeClass = "status-unknown";
        }
    ?>

    <article class="moderation-card">

        <!-- Imagen del post -->
        <?php if (!empty($post['image'])): ?>
            <img src="/Proyecto_BlogPHP/public<?= htmlspecialchars($post['image']) ?>"
                 class="moderation-cover">
        <?php endif; ?>

        <!-- Contenido del post -->
        <div class="moderation-body">

            <h3 class="moderation-title">
                <?= htmlspecialchars($post['title']) ?>
            </h3>

            <?php if (!empty($post['subtitle'])): ?>
                <p class="moderation-subtitle">
                    <em><?= htmlspecialchars($post['subtitle']) ?></em>
                </p>
            <?php endif; ?>

            <p class="moderation-excerpt">
                <?= htmlspecialchars(mb_substr($post['content'], 0, 150)) ?>...
            </p>

            <p class="moderation-author">
                Autor:
                <strong><?= htmlspecialchars($post['username']) ?></strong>
            </p>

            <!-- Badge de estado -->
            <span class="status-badge <?= $badgeClass ?>">
                <?= $displayText ?>
            </span>

        </div>

        <!-- Acciones de moderación -->
        <div class="moderation-actions">

            <!-- Ver -->
            <a href="/Proyecto_BlogPHP/public/?controller=posts&action=view&id=<?= $post['id'] ?>"
               class="btn-mod btn-view">
                👁 Ver
            </a>

            <!-- Aprobar -->
            <?php if ($status !== 'approved'): ?>
                <a href="/Proyecto_BlogPHP/public/?controller=panel&action=approve&id=<?= $post['id'] ?>"
                   class="btn-mod btn-approve">
                    ✓ Aprobar
                </a>
            <?php endif; ?>

            <!-- Rechazar -->
            <?php if ($status !== 'rejected'): ?>
                <a href="/Proyecto_BlogPHP/public/?controller=panel&action=reject&id=<?= $post['id'] ?>"
                   class="btn-mod btn-reject">
                    ✖ Rechazar
                </a>
            <?php endif; ?>

            <!-- Borrar -->
            <a href="/Proyecto_BlogPHP/public/?controller=panel&action=delete&id=<?= $post['id'] ?>"
               class="btn-mod btn-delete">
                🗑 Borrar
            </a>

        </div>

    </article>

<?php endforeach; ?>
