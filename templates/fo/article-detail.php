<?php
$extraCss = ['article-detail.min.css'];
$createdAt = !empty($article['created_at']) ? formatDate((string)$article['created_at']) : 'Date inconnue';
$authors = trim((string)($article['authors'] ?? '')) ?: 'Redaction';
$summary = trim((string)($article['summary'] ?? ''));
$cover = trim((string)($article['cover'] ?? ''));

$extraHead = '
    <meta name="description" content="' . e($summary ?: $article['title']) . '">

    <meta property="og:title" content="' . e($article['title']) . '">
    <meta property="og:description" content="' . e($summary) . '">
    <meta property="og:type" content="article">
    <meta property="og:url" content="' . e($_SERVER['REQUEST_URI']) . '">
';

require __DIR__ . '/../layout/head.php';
require __DIR__ . '/../layout/nav.php';
?>
<div class="fo-lm-wrap">
    <main class="fo-lm-main">
        <article class="fo-lm-article" aria-label="Article">
            <header class="fo-lm-header">
                <h1 <?php if ($cover !== ''): ?> style="background-image: linear-gradient(rgba(80, 80, 80, 0.45), rgba(80, 80, 80, 0.45)), url('<?= e($cover) ?>'); background-size: stretch; background-repeat: no-repeat; background-position: center; padding: 1.5rem;"
                    <?php endif; ?> class="fo-lm-title">
                        <?= e($article['title'] ?? $pageTitle) ?>
                </h1>

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