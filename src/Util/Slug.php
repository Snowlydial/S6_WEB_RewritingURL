<?php

namespace Util;

//?=== Slug & Summary Generation
function generateSlug(string $input): string {
    $str = mb_strtolower($input, 'UTF-8');
    $str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
    $str = preg_replace('/[^a-z0-9\s]/', '', $str);
    $str = trim($str);
    $str = preg_replace('/\s+/', '-', $str);
    return $str;
}

function generateSummary(string $title, string $content, int $max = 150): string {
    $plain = strip_tags($content);
    $combined = $title . ' - ' . $plain;
    if (mb_strlen($combined) > $max) {
        return mb_substr($combined, 0, $max - 3) . '...';
    }
    return $combined;
}
