<?php
$extraCss = ['article-detail.css'];
$createdAt = !empty($article['created_at']) ? formatDate((string)$article['created_at']) : 'Date inconnue';
$authors = trim((string)($article['authors'] ?? '')) ?: 'Redaction';
$summary = trim((string)($article['summary'] ?? ''));

$extraHead = '
    <meta name="description" content="' . e($summary ?: $article['title']) . '">

    <!-- Open Graph (Facebook, WhatsApp, etc.) -->
    <meta property="og:title" content="' . e($article['title']) . '">
    <meta property="og:description" content="' . e($summary) . '">
    <meta property="og:type" content="article">
    <meta property="og:url" content="' . e($_SERVER['REQUEST_URI']) . '">
    
    <!-- Optionnel si tu as une image -->
    <meta property="og:image" content="' . e($article['image'] ?? '/default.jpg') . '">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="' . e($article['title']) . '">
    <meta name="twitter:description" content="' . e($summary) . '">
';
require __DIR__ . '/../layout/head.php';
require __DIR__ . '/../layout/nav.php';
?>
<div class="fo-lm-wrap">
    <main class="fo-lm-main">
        <article class="fo-lm-article" aria-label="Article">
            <header class="fo-lm-header">
                <p class="fo-lm-kicker">PROCHE-ORIENT · INTERNATIONAL</p>
                <h1 class="fo-lm-title"><?= e($article['title'] ?? $pageTitle) ?></h1>

                <div class="fo-lm-tags" aria-label="Mots-clés">
                    <span class="fo-lm-tag">En direct</span>
                    <span class="fo-lm-tag">Nucleaire iranien</span>
                </div>

                <div class="fo-lm-divider"></div>

                <?php if ($summary !== ''): ?>
                    <p class="fo-lm-summary"><?= e($summary) ?></p>
                <?php endif; ?>

                <p class="fo-lm-meta">
                    Publie le <?= e($createdAt) ?>
                    <span class="fo-lm-dot">•</span>
                    <?= e($authors) ?>
                </p>
            </header>

            <section class="fo-lm-content" aria-label="Contenu de l'article">
                <?= $article['content'] ?? '' ?>
            </section>
        </article>
    </main>
</div>

</body>

</html>