<?php
    $currentPath = currentPath();
?>
<nav class="site-nav">
    <a href="/" class="site-nav__logo display">Iran<span>Info</span></a>
    <ul class="site-nav__links">
        <?php $articleListPath = isLoggedIn() ? '/article/list' : '/'; ?>
        <li><a href="<?= e($articleListPath) ?>" <?= ($currentPath === '/article/list' || $currentPath === '/') ? 'class="active"' : '' ?>>Articles</a></li>
        <?php if (isLoggedIn()): ?>
            <li><a href="/article/add" <?= $currentPath === '/article/add' ? 'class="active"' : '' ?>>Rédaction</a></li>
            <li><a href="/logout">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="/login" <?= $currentPath === '/login' ? 'class="active"' : '' ?>>Connexion</a></li>
        <?php endif; ?>
    </ul>
</nav>
