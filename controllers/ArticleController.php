<?php

require_once __DIR__ . '/../src/Article.php';
require_once __DIR__ . '/../src/Util.php';

function handleArticleList(): void {
    requireLogin();
    $articles = Article::findAll();
    $pageTitle = 'Articles';
    require __DIR__ . '/../templates/bo/article-list.php';
}

function handleArticleAdd(): void {
    requireLogin();
    $article  = [];
    $pageTitle = 'Nouvel article';
    require __DIR__ . '/../templates/bo/article-form.php';
}

function handleArticleEdit(int $id): void {
    requireLogin();
    $article = Article::findById($id);
    if (!$article) { http_response_code(404); die('Article not found'); }
    $pageTitle = 'Modifier l\'article';
    require __DIR__ . '/../templates/bo/article-form.php';
}

function handleArticleSave(): void {
    requireLogin();
    verifyCsrf();
    Article::save($_POST);
    redirect('/article/list');
}

function handleArticleDelete(int $id): void {
    requireLogin();
    Article::delete($id);
    redirect('/article/list');
}

function handleArticleView(string $slug): void {
    $article = Article::findBySlug($slug);
    if (!$article) { http_response_code(404); die('Article not found'); }
    $pageTitle = htmlspecialchars($article['title']);
    require __DIR__ . '/../templates/fo/article-detail.php';
}

function handleImageUpload(): void {
    requireLogin();

    // CSRF via header (sent by our JS fetch)
    $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!hash_equals(csrfToken(), $token)) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'CSRF invalid']);
        exit;
    }

    if (empty($_FILES['file'])) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'No file received']);
        exit;
    }

    $uploadDir = __DIR__ . '/../public/uploads';
    $result = uploadImage($_FILES['file'], $uploadDir);

    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}
