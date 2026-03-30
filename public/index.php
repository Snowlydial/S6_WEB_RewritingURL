<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Util.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/ArticleController.php';

// Start session before any template output to avoid header warnings.
sessionStart();

$method = $_SERVER['REQUEST_METHOD'];
$path   = currentPath();

// =============================================
// ROUTER
// =============================================

// Auth
if ($path === '/login') {
    if ($method === 'POST') { handleLogin(); exit; }
    $pageTitle = 'Connexion';
    require __DIR__ . '/../templates/login.php';
    exit;
}

if ($path === '/logout') {
    handleLogout();
    exit;
}

// Article CRUD
if ($path === '/article/list' || $path === '/') {
    handleArticleList(); exit;
}
if ($path === '/article/add') {
    if ($method === 'GET')  { handleArticleAdd(); exit; }
}
if ($path === '/article/save') {
    if ($method === 'POST') { handleArticleSave(); exit; }
}
if ($path === '/article/upload-image') {
    if ($method === 'POST') { handleImageUpload(); exit; }
}

// Dynamic routes: /article/edit/{id}, /article/delete/{id}
if (preg_match('#^/article/edit/(\d+)$#', $path, $m)) {
    handleArticleEdit((int)$m[1]); exit;
}
if (preg_match('#^/article/delete/(\d+)$#', $path, $m)) {
    handleArticleDelete((int)$m[1]); exit;
}

// SEO URL: /article/{id}-{date}-{slug}
if (preg_match('#^/article/(\d+)-[\d]+-(.+)$#', $path, $m)) {
    $article = \Article::findById((int)$m[1]);
    if ($article) { handleArticleView($article['slug']); exit; }
}

// 404
http_response_code(404);
echo '<h1>404 — Page not found</h1>';
