<h2 class="posts-title">Solicitudes de nuevos editores</h2>

<?php if (empty($requests)): ?>
    <p style="text-align:center; opacity:.7; margin-top:40px;">
        No hay solicitudes pendientes.
    </p>
<?php else: ?>

    <?php foreach ($requests as $req): ?>
        <article class="moderation-card">

            <img src="/Proyecto_BlogPHP/public/avatars/<?= $req['avatar'] ?>"
                 class="moderation-cover">

            <div class="moderation-body">
                <h3 class="moderation-title"><?= $req['username'] ?></h3>
                <p class="moderation-subtitle">
                    Solicita permiso para publicar contenido.
                </p>
            </div>

            <div class="moderation-actions">

                <a class="btn-mod btn-approve"
                   href="/Proyecto_BlogPHP/public/?controller=panel&action=approveEditor&id=<?= $req['id'] ?>">
                   ✓ Aprobar
                </a>

                <a class="btn-mod btn-reject"
                   href="/Proyecto_BlogPHP/public/?controller=panel&action=rejectEditor&id=<?= $req['id'] ?>">
                   ✖ Rechazar
                </a>

            </div>

        </article>
    <?php endforeach; ?>

<?php endif; ?>
