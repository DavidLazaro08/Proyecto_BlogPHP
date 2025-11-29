<?php
// ============================================================
// NORMALIZAR RUTA DEL AVATAR DEL USUARIO
// ============================================================

// Avatar guardado en la BD o default
$avatar = $user['avatar'] ?: "/avatars/Default.jpg";

// Asegurar que siempre empiece por /avatars/
if (strpos($avatar, "/avatars/") !== 0) {
    $avatar = "/avatars/" . ltrim($avatar, "/");
}

// Ruta absoluta para mostrarlo en el navegador
$avatarPath = "/Proyecto_BlogPHP/public" . $avatar;


// ============================================================
// CARGAR POSTS DEL USUARIO
// ============================================================

require_once __DIR__ . "/../../models/Post.php";
$postModel = new Post();
$posts = $postModel->getPostsByUser($user['id']);
?>

<h2 class="profile-title">Mi perfil</h2>
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


        <!-- =======================================================
             FORMULARIO INVISIBLE PARA CAMBIAR AVATAR DIRECTO
        ======================================================== -->
        <form id="avatarForm"
              action="/Proyecto_BlogPHP/public/?controller=users&action=updateAvatar"
              method="POST"
              enctype="multipart/form-data">

            <input type="file"
                   id="avatarInput"
                   name="avatar"
                   accept="image/*"
                   style="display:none;">

            <!-- Botón visible (solo dispara el selector) -->
            <button type="button"
                    class="btn-small"
                    onclick="document.getElementById('avatarInput').click()">
                Cambiar avatar
            </button>
        </form>

        <script>
        // Cuando el usuario selecciona un archivo → auto-subir
        document.getElementById('avatarInput').addEventListener('change', function () {
            if (this.files.length > 0) {
                document.getElementById('avatarForm').submit();
            }
        });
        </script>


        <!-- =======================================================
             SOLICITUD PARA SER EDITOR
        ======================================================== -->
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

    </div>


    <!-- =======================================================
         COLUMNA DERECHA — LISTA DE PUBLICACIONES
    ======================================================== -->
    <div class="profile-right">

        <h3 class="profile-section-title">Mis publicaciones</h3>

        <?php if (empty($posts)): ?>

            <p style="opacity:.7;">No tienes publicaciones todavía.</p>

        <?php else: ?>

            <?php
            // Traducciones bonitas para estado
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

    </div>

</div>
