<?php
    $extraCss = ['article-form.min.css'];
    $isEdit   = !empty($article['id_article']);
    $extraHead = '
    <meta name="csrf-token" content="' . e(csrfToken()) . '">';
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
            <span class="section-label">
                <?= $isEdit ? 'ID #' . e($article['id_article']) : 'Nouveau' ?>
            </span>
        </div>

        <form action="/article/save" method="post" class="article-form">
            <?= csrfField() ?>
            <input type="hidden" name="id" value="<?= e($article['id_article'] ?? '') ?>">

            <div class="form-row">
                <div class="field">
                    <label for="title">Titre de l'article</label>
                    <input type="text" id="title" name="title"
                           value="<?= e($article['title'] ?? '') ?>"
                           placeholder="Saisir un titre...">
                </div>
                <div class="field">
                    <label for="authors">Auteur(s)</label>
                    <input type="text" id="authors" name="authors"
                           value="<?= e($article['authors'] ?? '') ?>"
                           placeholder="Nom_Prénom1, Nom_Prénom2, etc...">
                </div>
            </div>

            <div class="form-block form-block--editor">
                <div class="field">
                    <label class="section-label">Contenu</label>
                    <textarea id="contentEditor" name="content"><?= e($article['content'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="/article/list" class="btn btn--ghost">Annuler</a>
                <button type="submit" class="btn btn--primary">Enregistrer l'article</button>
            </div>
        </form>

    </main>
</div>

<script src="/js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '#contentEditor',
    license_key: 'gpl',
    plugins: ['anchor','autolink','charmap','codesample','emoticons','link','lists','image','media','searchreplace','table','visualblocks','wordcount'],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table | align lineheight | checklist numlist bullist indent outdent | image | removeformat',
    images_upload_handler: function(blobInfo) {
        return new Promise((resolve, reject) => {
            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/article/upload-image');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
            xhr.onload = () => {
                if (xhr.status !== 200) { reject('Upload failed: ' + xhr.status); return; }
                const json = JSON.parse(xhr.responseText);
                if (json.error) { reject(json.error); return; }
                resolve(json.location);
            };
            xhr.onerror = () => reject('Upload failed');
            const fd = new FormData();
            fd.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(fd);
        });
    },
    automatic_uploads: true,
    convert_urls: false,
    skin: 'oxide-dark',
    content_css: 'dark',
    height: 520,
    menubar: false,
    branding: false,
});
</script>

</body>
</html>
