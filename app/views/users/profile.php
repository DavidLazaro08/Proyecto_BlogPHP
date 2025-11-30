<?php
// ============================================================
// NORMALIZAR RUTA DEL AVATAR DEL USUARIO
// ============================================================

$avatar = $user['avatar'] ?: "/avatars/Default.jpg";

if (strpos($avatar, "/avatars/") !== 0) {
    $avatar = "/avatars/" . ltrim($avatar, "/");
}

$avatarPath = "/Proyecto_BlogPHP/public" . $avatar;


// ============================================================
// CARGAR POSTS DEL USUARIO
// ============================================================

require_once __DIR__ . "/../../models/Post.php";
$postModel = new Post();
$posts = $postModel->getPostsByUser($user['id']);
?>

<div class="edit-header">
    <a href="javascript:history.back()" class="btn-back">← Volver</a>

    <h2 class="profile-title">Mi perfil</h2>
</div>

<p class="profile-subtitle">Aquí podrás ver y modificar tus datos.</p>


<div class="profile-wrapper">

    <!-- =======================================================
         COLUMNA IZQUIERDA — DATOS DEL USUARIO
    ======================================================== -->
    <div class="profile-left">

        <!-- AVATAR PRINCIPAL -->
        <img src="<?= $avatarPath ?>"
             alt="avatar"
             class="profile-avatar"
             id="profileAvatar">

        <!-- MODAL PARA AMPLIAR AVATAR -->
        <div class="avatar-modal" id="avatarModal">
            <span class="avatar-close" id="avatarClose">✕</span>
            <img src="<?= $avatarPath ?>" class="avatar-modal-img">
        </div>

        <h3 class="profile-username"><?= htmlspecialchars($user['username']) ?></h3>
        <p class="profile-email"><?= htmlspecialchars($user['email']) ?></p>

        <p class="profile-role">
            Rol:
            <span class="role-badge role-<?= strtolower($user['role']) ?>">
                <?= ucfirst($user['role']) ?>
            </span>
        </p>

        <!-- ==========================================
             BOTONES (Avatar + Editar datos)
        ============================================== -->
        <div class="profile-buttons">

            <!-- BOTÓN QUE ABRE EL SELECTOR DE ARCHIVOS -->
            <button type="button"
                    class="btn-small"
                    onclick="document.getElementById('avatarInput').click()">
                Cambiar avatar
            </button>

            <!-- EDITAR DATOS -->
            <a href="/Proyecto_BlogPHP/public/?controller=users&action=editProfileForm"
               class="btn-small">
                Editar datos
            </a>

        </div>

        <!-- ==========================================
             SOLICITUD PARA SER EDITOR
        ============================================== -->
        <?php if ($_SESSION['role'] === 'user'): ?>

            <?php $pending = (new User())->hasPendingEditorRequest($_SESSION['user_id']); ?>

            <?php if ($pending): ?>
                <p class="request-pending">⧗ Solicitud enviada — pendiente</p>
            <?php else: ?>
                <a href="/Proyecto_BlogPHP/public/?controller=users&action=requestEditor"
                   class="btn-request-editor">
                   Solicitar ser editor
                </a>
            <?php endif; ?>

        <?php endif; ?>

    </div> <!-- CIERRE REAL DE profile-left -->


    <!-- =======================================================
         COLUMNA DERECHA — POSTS DEL USUARIO
    ======================================================== -->
    <div class="profile-right">

        <h3 class="profile-section-title">Mis publicaciones</h3>

        <?php if (empty($posts)): ?>

            <p style="opacity:.7;">No tienes publicaciones todavía.</p>

        <?php else: ?>

            <?php
            $statusLabels = [
                'approved' => 'Aprobado',
                'pending'  => 'Pendiente',
                'rejected' => 'Rechazado',
                'draft'    => 'Borrador'
            ];
            ?>

            <table class="profile-post-table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Ver</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($posts as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['title']) ?></td>

                            <td>
                                <span class="post-status-badge status-<?= strtolower($p['status']) ?>">
                                    <?= $statusLabels[strtolower($p['status'])] ?? $p['status'] ?>
                                </span>
                            </td>

                            <td><?= substr($p['created_at'], 0, 10) ?></td>

                            <td>
                                <a href="/Proyecto_BlogPHP/public/?controller=posts&action=view&id=<?= $p['id'] ?>"
                                   class="view-eye">👁</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>

        <script src="/Proyecto_BlogPHP/public/js/avatar-modal.js"></script>

    </div> <!-- FIN COLUMNA DERECHA -->

</div> <!-- FIN profile-wrapper -->


<!-- =======================================================
     FORMULARIO OCULTO PARA SUBIR AVATAR
     (FUERA DE TODO, AQUÍ SÍ CORRECTO)
=========================================================== -->
<form id="avatarForm"
      action="/Proyecto_BlogPHP/public/?controller=users&action=changeAvatar"
      method="POST"
      enctype="multipart/form-data"
      style="display:none;">

    <input type="file"
           id="avatarInput"
           name="avatar"
           accept="image/*">
</form>

<script>
document.getElementById('avatarInput').addEventListener('change', function () {
    if (this.files.length > 0) {
        document.getElementById('avatarForm').submit();
    }
});
</script>
