<h2 class="panel-title">Publicaciones pendientes</h2>
<p class="panel-subtitle">Revisa y modera las publicaciones enviadas por editores.</p>

<?php if (empty($pending)): ?>

    <p style="margin-top:40px; text-align:center; opacity:0.7;">
        No hay publicaciones pendientes por ahora.
    </p>

<?php else: ?>

<div class="panel-grid">

    <?php foreach ($pending as $post): ?>
        <div class="panel-card">

            <h3><?= htmlspecialchars($post['title']) ?></h3>
            <p><?= htmlspecialchars($post['subtitle']) ?></p>

            <div class="panel-card-actions">
                <a class="approve-btn"
                   href="/Proyecto_BlogPHP/public/?controller=panel&action=approve&id=<?= $post['id'] ?>">
                    ✔ Aprobar
                </a>

                <a class="reject-btn"
                   href="/Proyecto_BlogPHP/public/?controller=panel&action=reject&id=<?= $post['id'] ?>">
                    ✖ Rechazar
                </a>
            </div>

            <div class="panel-card-footer">
                <img class="panel-avatar"
                     src="/Proyecto_BlogPHP/public/avatars/<?= htmlspecialchars($post['avatar']) ?>">
                <span><?= htmlspecialchars($pos
