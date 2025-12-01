<h2 class="posts-title">Archivo completo del mapa sonoro</h2>
<p class="posts-subtitle">Explora todas las publicaciones del atlas.</p>

<?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'editor'): ?>
    <a href="/Proyecto_BlogPHP/public/?controller=posts&action=createForm"
       class="br-create-link">
        + Crear nuevo post
    </a>
<?php endif; ?>

<div class="posts-grid">

    <?php foreach ($posts as $post): ?>
        <article class="post-card">

            <!-- IMAGEN -->
            <div class="post-card-image-wrap">
                <?php if (!empty($post['image'])): ?>
                    <img src="/Proyecto_BlogPHP/public<?= htmlspecialchars($post['image']) ?>"
                         class="post-card-image">
                <?php endif; ?>
            </div>

            <!-- CUERPO -->
            <div class="post-card-body">

                <h3 class="post-card-title">
                    <?= htmlspecialchars($post['title']) ?>
                </h3>

                <?php if (!empty($post['subtitle'])): ?>
                    <p class="post-card-subtitle">
                        <em><?= htmlspecialchars($post['subtitle']) ?></em>
                    </p>
                <?php endif; ?>

                <p class="post-card-excerpt">
                    <?= htmlspecialchars(mb_substr($post['content'], 0, 110)) ?>...
                </p>

                <?php
                // --------------------------------------------------------
                // CONTROL DE SI MOSTRAR EL ESTADO DEL POST
                // --------------------------------------------------------
                $role       = $_SESSION['role'];
                $userId     = $_SESSION['user_id'];

                $showStatus =
                    ($role === 'admin')
                    || ($role === 'editor' && $post['author_id'] == $userId);

                // Normalizamos estado
                $status = strtolower(trim($post['status']));

                // Texto + clase CSS
                $statusText  = "Estado desconocido";
                $statusClass = "status-unknown";

                switch ($status) {
                    case 'approved':
                        $statusText  = "Aprobado";
                        $statusClass = "status-approved";
                        break;

                    case 'pending':
                        $statusText  = "Pendiente de aprobación";
                        $statusClass = "status-pending";
                        break;

                    case 'rejected':
                        $statusText  = "Rechazado";
                        $statusClass = "status-rejected";
                        break;
                }
                ?>

                <!-- ESTADO DEL POST -->
                <?php if ($showStatus): ?>
                    <span class="post-status <?= $statusClass ?>">
                        <?= $statusText ?>
                    </span>
                <?php endif; ?>


                <!-- PIE TARJETA -->
                <div class="post-card-footer">

                    <?php
                    // Normalizar avatar
                    $avatar = $post['avatar'] ?? "";

                    if (str_starts_with($avatar, "/avatars/")) {
                        $avatar = substr($avatar, strlen("/avatars/"));
                    }

                    if (!$avatar) {
                        $avatar = "default.jpg";
                    }
                    ?>

                    <div class="post-card-author">
                        <img src="/Proyecto_BlogPHP/public/avatars/<?= htmlspecialchars($avatar) ?>"
                             class="post-card-avatar">
                        <span><?= htmlspecialchars($post['username']) ?></span>
                    </div>

                    <a class="post-card-link"
                       href="/Proyecto_BlogPHP/public/?controller=posts&action=view&id=<?= $post['id'] ?>">
                        Leer más →
                    </a>

                </div>

            </div>

        </article>
    <?php endforeach; ?>

</div>
