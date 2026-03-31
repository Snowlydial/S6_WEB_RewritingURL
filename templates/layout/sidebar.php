<?php $currentPath = currentPath(); ?>
<aside class="bo-sidebar">
    <div class="bo-sidebar__section">
        <span class="section-label">Contenu</span>
    </div>
    <nav class="bo-sidebar__nav">
        <a href="/article/list" <?= $currentPath === '/article/list' ? 'class="active"' : '' ?>>
            <span class="bo-sidebar__dot"></span> Tous les articles
        </a>
        <a href="/article/add" <?= $currentPath === '/article/add' ? 'class="active"' : '' ?>>
            <span class="bo-sidebar__dot"></span> Nouvel article
        </a>
    </nav>
    <div class="bo-sidebar__section" style="margin-top:auto;padding-top:2rem;border-top:1px solid var(--grey-2)">
        <span class="section-label">Système</span>
    </div>
    <nav class="bo-sidebar__nav">
        <a href="/logout"><span class="bo-sidebar__dot"></span> Déconnexion</a>
    </nav>
</aside>
