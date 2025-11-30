
<?php
// Función global para normalizar avatar (misma lógica que en el perfil)
function normalizeAvatar($avatar)
{
    // Si no hay avatar → usar Default
    if (!$avatar) {
        return "/Proyecto_BlogPHP/public/avatars/Default.jpg";
    }

    // Si NO empieza por "/avatars/" lo añadimos
    if (strpos($avatar, "/avatars/") !== 0) {
        $avatar = "/avatars/" . ltrim($avatar, "/");
    }

    // Devolver ruta correcta absoluta
    return "/Proyecto_BlogPHP/public" . $avatar;
}
?>

<div class="mod-header">
    <a href="javascript:history.back()" class="btn-back">← Volver</a>
    <h2 class="posts-title">Gestión de usuarios</h2>
</div>

<table class="profile-post-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Avatar</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= ucfirst($u['role']) ?></td>

                <td>
                    <img src="<?= normalizeAvatar($u['avatar']) ?>"
                        style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                </td>

                <!-- ACCIONES (TODO JUNTO EN UNA CELDA) -->
                <td style="display:flex; gap:10px;">

                    <!-- EDITAR -->
                    <a href="/Proyecto_BlogPHP/public/?controller=panel&action=editUser&id=<?= $u['id'] ?>"
                    class="btn-mod btn-view">
                        Editar
                    </a>

                    <!-- ELIMINAR -->
                    <a href="/Proyecto_BlogPHP/public/?controller=panel&action=deleteUser&id=<?= $u['id'] ?>"
                    class="btn-mod btn-delete"
                    onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
                        Eliminar
                    </a>

                    <!-- ACTIVAR / SUSPENDER -->
                    <?php if ($u['active'] == 1): ?>
                        <a href="/Proyecto_BlogPHP/public/?controller=panel&action=disableUser&id=<?= $u['id'] ?>"
                        class="btn-mod btn-reject">
                            Suspender
                        </a>
                    <?php else: ?>
                        <a href="/Proyecto_BlogPHP/public/?controller=panel&action=enableUser&id=<?= $u['id'] ?>"
                        class="btn-mod btn-approve">
                            Activar
                        </a>
                    <?php endif; ?>

                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>

</table>
