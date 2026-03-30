<?php

// Load all utility modules
require_once __DIR__ . '/Util/Session.php';
require_once __DIR__ . '/Util/Csrf.php';
require_once __DIR__ . '/Util/Router.php';
require_once __DIR__ . '/Util/Slug.php';
require_once __DIR__ . '/Util/ImageUpload.php';
require_once __DIR__ . '/Util/Html.php';

// Create global wrapper functions that delegate to namespaced functions
function sessionStart(): void { \Util\sessionStart(); }
function isLoggedIn(): bool { return \Util\isLoggedIn(); }
function requireLogin(): void { \Util\requireLogin(); }
function currentUser(): ?array { return \Util\currentUser(); }
function csrfToken(): string { return \Util\csrfToken(); }
function csrfField(): string { return \Util\csrfField(); }
function verifyCsrf(): void { \Util\verifyCsrf(); }
function redirect(string $path): never { \Util\redirect($path); }
function currentPath(): string { return \Util\currentPath(); }
function generateSlug(string $input): string { return \Util\generateSlug($input); }
function generateSummary(string $title, string $content, int $max = 150): string { return \Util\generateSummary($title, $content, $max); }
function uploadImage(array $file, string $uploadDir): array { return \Util\uploadImage($file, $uploadDir); }
function resizeAndSave(string $src, string $mime, string $dest, int $maxW, int $maxH, int $quality, string $targetFormat = 'jpeg'): string|false { return \Util\resizeAndSave($src, $mime, $dest, $maxW, $maxH, $quality, $targetFormat); }
function e(mixed $val): string { return \Util\e($val); }
function formatDate(string $datetime, string $tz = 'Indian/Antananarivo'): string { return \Util\formatDate($datetime, $tz); }
