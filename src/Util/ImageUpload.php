<?php

namespace Util;

//?=== Image Upload & Resize (using GD, no external libraries)
function uploadImage(array $file, string $uploadDir): array {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'Upload error code: ' . $file['error']];
    }

    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $mime = mime_content_type($file['tmp_name']);
    if (!in_array($mime, $allowed, true)) {
        return ['error' => 'File type not allowed.'];
    }

    $safeName = preg_replace('/[^a-z0-9._-]/i', '_', basename($file['name']));
    $baseName = time() . '_' . pathinfo($safeName, PATHINFO_FILENAME);
    $basePath = rtrim($uploadDir, '/') . '/' . $baseName;

    $savedFormat = resizeAndSave($file['tmp_name'], $mime, $basePath . '.webp', 1000, 1000, 88, 'webp');

    // Fallback to JPEG if WebP encoding fails.
    if ($savedFormat === false) {
        $savedFormat = resizeAndSave($file['tmp_name'], $mime, $basePath . '.jpg', 1000, 1000, 90, 'jpeg');
    }

    if ($savedFormat === false) {
        return ['error' => 'Failed to process image.'];
    }

    $normalizedUploadDir = rtrim(str_replace('\\', '/', $uploadDir), '/');
    $publicPos = strpos($normalizedUploadDir, '/public');

    // Build a URL path that mirrors the target folder under /public.
    if ($publicPos !== false) {
        $urlBase = substr($normalizedUploadDir, $publicPos + strlen('/public'));
    } else {
        $urlBase = '/uploads';
    }

    $urlBase = rtrim($urlBase, '/');
    return ['location' => ($urlBase !== '' ? $urlBase : '/uploads') . '/' . $baseName . '.' . $savedFormat];
}

function resizeAndSave(string $src, string $mime, string $dest, int $maxW, int $maxH, int $quality, string $targetFormat): string|false {
    $original = match($mime) {
        'image/jpeg' => imagecreatefromjpeg($src),
        'image/png'  => imagecreatefrompng($src),
        'image/webp' => imagecreatefromwebp($src),
        'image/gif'  => imagecreatefromgif($src),
        default      => false,
    };

    if (!$original) return false;

    $origW = imagesx($original);
    $origH = imagesy($original);

    // Calculate new dimensions preserving aspect ratio
    $ratio = min($maxW / $origW, $maxH / $origH, 1.0); // never upscale
    $newW  = (int) round($origW * $ratio);
    $newH  = (int) round($origH * $ratio);

    $resized = imagecreatetruecolor($newW, $newH);

    $sourceHasAlpha = in_array($mime, ['image/png', 'image/webp', 'image/gif'], true);

    // Keep alpha-safe canvas for formats that may contain transparency.
    if ($sourceHasAlpha || $targetFormat === 'webp') {
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
        imagefill($resized, 0, 0, $transparent);
    } else {
        $white = imagecolorallocate($resized, 255, 255, 255);
        imagefill($resized, 0, 0, $white);
    }

    imagecopyresampled($resized, $original, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
    $result = match($targetFormat) {
        'webp' => imagewebp($resized, $dest, $quality),
        'jpeg' => imagejpeg($resized, $dest, $quality),
        default => false,
    };

    imagedestroy($original);
    imagedestroy($resized);

    if (!$result) {
        return false;
    }

    return $targetFormat;
}
