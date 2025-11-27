<article class="post-full">

    <h1 style="color:#8fbaff; text-align:center; margin-bottom:10px;">
        <?= htmlspecialchars($post['title']) ?>
    </h1>

    <?php if (!empty($post['subtitle'])): ?>
        <h3 style="text-align:center; color:#9bb0d3; margin-bottom:25px;">
            <em><?= htmlspecialchars($post['subtitle']) ?></em>
        </h3>
    <?php endif; ?>

    <?php if (!empty($post['image'])): ?>
        <img src="/Proyecto_BlogPHP/public<?= htmlspecialchars($post['image']) ?>"
             class="post-full-image">
    <?php endif; ?>

    <p class="post-full-content">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </p>

</article>

<p style="text-align:center; margin-top:30px;">
    <a href="/Proyecto_BlogPHP/public/?controller=posts&action=index"
       style="color:#66b3ff;">
       ← Volver al archivo completo
    </a>
</p>
