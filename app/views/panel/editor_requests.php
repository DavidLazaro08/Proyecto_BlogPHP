<?php
// ============================================================
// NORMALIZAR AVATAR (igual que en gestión de usuarios)
// ============================================================
function normalizeAvatar($avatar)
{
    if (!$avatar) {
        return "/Proyecto_BlogPHP/public/avatars/Default.jpg";
    }

    if (strpos($avatar, "/avatars/") !== 0) {
        $avatar = "/avatars/" . ltrim($avatar, "/");
    }

    return "/Proyecto_BlogPHP/public" . $avatar;
}
?>

<div class="mod-header">
    <a href="javascript:history.back()" class="btn-back">← Volver</a>
    <h2 class="posts-title">Solicitudes de nuevos editores</h2>
</div>

<?php if (empty($requests)): ?>

    <p style="color:#9bb0d3; text-align:center; margin-top:40px;">
        No hay solicitudes pendientes.
    </p>

<?php else: ?>

    <?php foreach ($requests as $req): ?>
        <div class="moderation-card">

            <!-- AVATAR -->
            <img src="<?= normalizeAvatar($req['avatar']) ?>"
                 class="moderation-cover"
                 style="width:130px; height:130px; object-fit:cover;">

            <!-- INFORMACIÓN -->
            <div class="moderation-body">
                <h3 class="moderation-title"><?= htmlspecialchars($req['username']) ?></h3>
                <p class="moderation-subtitle">
                    Solicita permiso para publicar contenido.
                </p>
            </div>

            <!-- ACCIONES -->
            <div class="moderation-actions">

                <a href="/Proyecto_BlogPHP/public/?controller=panel&action=approveEditor&id=<?= $req['id'] ?>"
                   class="btn-mod btn-approve">
                    ✓ Aprobar
                </a>

                <a href="/Proyecto_BlogPHP/public/?controller=panel&action=rejectEditor&id=<?= $req['id'] ?>"
                   class="btn-mod btn-reject">
                    ✗ Rechazar
                </a>

            </div>
        </div>
    <?php endforeach; ?>

<?php endif; ?>
