<?php
    $pageTitle = 'Articles';
    $extraCss = ['article-form.css'];
    require __DIR__ . '/../layout/head.php';
    require __DIR__ . '/../layout/nav.php';
?>

<div class="bo-layout">
    <?php require __DIR__ . '/../layout/sidebar.php'; ?>

    <main class="bo-main">
        <section class="lm-shell" aria-label="Back-office articles">
            <div class="lm-shell__header">
                <div class="lm-shell__title-group">
                    <p class="lm-kicker">PROCHE-ORIENT · INTERNATIONAL</p>
                    <h1><?= e($pageTitle) ?></h1>
                    <p class="lm-subtitle">Liste editoriale pour piloter la publication SEO et les operations CRUD.</p>
                </div>
                <div class="lm-shell__header-actions">
                    <span class="lm-count"><?= count($articles) ?> article(s)</span>
                    <a href="/article/add" class="btn btn--primary">Nouvel article</a>
                </div>
            </div>
            <div class="lm-divider"></div>

            <div class="lm-grid">
                <section class="lm-feed" aria-label="Liste des articles publies">
                    <?php if (empty($articles)): ?>
                        <article class="lm-item lm-item--empty">
                            <p class="lm-rubric">BACK-OFFICE</p>
                            <h2>Aucun article publie</h2>
                            <p>Creez votre premier article pour alimenter le Front Office avec des URL SEO propres.</p>
                            <div class="lm-actions">
                                <a href="/article/add" class="btn btn--secondary">Creer un article</a>
                            </div>
                        </article>
                    <?php else: ?>
                        <?php foreach ($articles as $index => $item): ?>
                            <?php
                                $createdAt = !empty($item['created_at']) ? strtotime($item['created_at']) : false;
                                $dateToken = $createdAt ? date('YmdHis', $createdAt) : date('YmdHis');
                                $slug = rawurlencode((string)($item['slug'] ?? 'article'));
                                $foUrl = '/article/' . (int)$item['id_article'] . '-' . $dateToken . '-' . $slug;
                                // $isLead = $index === 0;
                            ?>
                            <article class="lm-item ">
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
                                        <span class="lm-dot">•</span>
                                        ID #<?= (int)$item['id_article'] ?>
                                    </p>
                                    <div class="lm-actions">
                                        <a class="lm-action-link" href="/article/edit/<?= (int)$item['id_article'] ?>">Modifier</a>
                                        <a
                                            class="lm-action-link lm-action-link--danger"
                                            href="/article/delete/<?= (int)$item['id_article'] ?>"
                                            onclick="return confirm('Supprimer cet article ?');"
                                        >
                                            Supprimer
                                        </a>
                                    </div>
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
    </main>
</div>

</body>
</html>
