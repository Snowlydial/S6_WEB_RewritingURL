<?php
    $pageTitle = 'Articles';
    $extraCss = ['article-form.css'];
    require __DIR__ . '/../layout/head.php';
    require __DIR__ . '/../layout/nav.php';
?>

<div class="bo-layout">
    <?php require __DIR__ . '/../layout/sidebar.php'; ?>
    
    <main class="bo-main">
        <div class="bo-page-header">
            <div class="bo-page-header__left">
                <span class="accent-bar"></span>
                <h1><?= e($pageTitle) ?></h1>
            </div>
        </div>
        
        <p style="padding: 2rem; color: #999;">📝 This is a list, WIP</p>
    </main>
</div>

</body>
</html>
