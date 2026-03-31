<?php
    $extraCss = ['article-form.css'];
    require __DIR__ . '/../layout/head.php';
    require __DIR__ . '/../layout/nav.php';
?>

<!-- <div class="bo-layout"> -->
    <!-- <main class="bo-main" style="padding-left: 0; max-width: 1200px; margin: 0 auto; width: 100%;"> -->
        <section class="lm-shell" aria-label="Front-office articles">
            <div class="lm-shell__header">
                <div class="lm-shell__title-group">
                    <h1><?= e($pageTitle) ?></h1>
                    <p class="lm-subtitle">Les derniers articles publies.</p>
                </div>
                <div class="lm-shell__header-actions">
                    <span class="lm-count"><?= count($articles) ?> article(s)</span>
                </div>
            </div>
            <div class="lm-divider"></div>

            <div class="lm-grid">
                <section class="lm-feed" aria-label="Liste des articles publies">
                    <?php if (empty($articles)): ?>
                        <article class="lm-item lm-item--empty">
                            <p class="lm-rubric">FRONT-OFFICE</p>
                            <h2>Aucun article publie</h2>
                            <p>Revenez plus tard pour lire nos dernieres publications.</p>
                        </article>
                    <?php else: ?>
                        <?php foreach ($articles as $item): ?>
                            <?php
                                $createdAt = !empty($item['created_at']) ? strtotime($item['created_at']) : false;
                                $dateToken = $createdAt ? date('YmdHis', $createdAt) : date('YmdHis');
                                $slug = rawurlencode((string)($item['slug'] ?? 'article'));
                                $foUrl = '/article/' . (int)$item['id_article'] . '-' . $dateToken . '-' . $slug;
                            ?>
                            <article class="lm-item">
                                <div class="lm-item__body">
                                    <p class="lm-rubric"></p>
                                    <h2>
                                        <a href="<?= e($foUrl) ?>" class="lm-title-link">
                                            <?= e($item['title']) ?>
                                        </a>
                                    </h2>
                                    <p class="lm-summary"><?= e($item['summary'] ?: 'Aucun resume disponible pour cet article.') ?></p>
                                    <p class="lm-meta">
                                        Publie <?= $createdAt ? e(date('d/m/Y H:i', $createdAt)) : 'date inconnue' ?>
                                        <span class="lm-dot">•</span>
                                        <?= e($item['authors'] ?: 'Auteur non renseigne') ?>
                                    </p>
                                </div>
                                <div class="lm-item__media" aria-hidden="true">
                                    <span><?= strtoupper(substr((string)$item['title'], 0, 1)) ?></span>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </section>
            </div>
        </section>
    <!-- </main>
</div> -->

</body>
</html>
