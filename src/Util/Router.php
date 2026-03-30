<?php

namespace Util;

//?=== Routing & Path Utilities
function redirect(string $path): never {
    header('Location: ' . $path);
    exit;
}

function currentPath(): string {
    $uri = $_SERVER['REQUEST_URI'];
    $path = parse_url($uri, PHP_URL_PATH);
    return rtrim($path, '/') ?: '/';
}
