<?php
// ============================================================
// NORMALIZAR RUTA DE AVATAR
// ============================================================

$avatar = $user['avatar'] ?: "/avatars/default.png";

// Si el avatar NO empieza por "/avatars/", lo corregimos
if (strpos($avatar, "/avatars/") !== 0) {
    $avatar = "/avatars/" . ltrim($avatar, "/");
}

// Ruta pública final
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
         COLUMNA IZQUIERDA — INFORMACIÓN DEL USUARIO
    ======================================================== -->
    <div class="profile-left">

        <!-- AVATAR NORMAL (clicable) -->
        <img src="<?= $avatarPath ?>" 
             alt="avatar" 
             class="profile-avatar" 
             id="profileAvatar">

        <!-- MODAL PARA VER AVATAR AMPLIADO -->
        <div class="avatar-modal" id="avatarModal">
            <span class="avatar-close" id="avatarClose">✕</span>
            <img src="<?= $avatarPath ?>" class="avatar-modal-img">
        </div>

        <h3 class="profile-username"><?= htmlspecialchars($user['username']) ?></h3>
        <p class="profile-email"><?= htmlspecialchars($user['email']) ?></p>

        <!-- Rol -->
        <p class="profile-role">
            Rol:
            <span class="role-badge role-<?= strtolower($user['role']) ?>">
                <?= ucfirst($user['role']) ?>
            </span>
        </p>

        <!-- Botón cambiar avatar (fase futura) -->
        <button class="btn-small">Cambiar avatar (próxima fase)</button>

        <!-- Solicitud para ser editor -->
        <?php if ($_SESSION['role'] === 'user'): ?>

            <?php 
            $pending = (new User())->hasPendingEditorRequest($_SESSION['user_id']);
            ?>

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
         COLUMNA DERECHA — PUBLICACIONES DEL USUARIO
    ======================================================== -->
    <div class="profile-right">

        <h3 class="profile-section-title">Mis publicaciones</h3>

        <?php if (empty($posts)): ?>

            <p style="opacity:.7;">No tienes publicaciones todavía.</p>

        <?php else: ?>

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
                                    <?= ucfirst($p['status']) ?>
                                </span>
                            </td>

                            <td><?= substr($p['created_at'], 0, 10) ?></td>

                            <td>
                                <a href="/Proyecto_BlogPHP/public/?controller=post&action=view&id=<?= $p['id'] ?>"
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