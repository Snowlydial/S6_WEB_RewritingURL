<?php

namespace Util;

//?=== Image Upload & Resize (using GD, no external libraries)
function uploadImage(array $file, string $uploadDir): array {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'Upload error code: ' . $file['error']];
    }

    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $mime = mime_content_type($file['tmp_name']);
    if (!in_array($mime, $allowed)) {
        return ['error' => 'File type not allowed.'];
    }

    $fileName = time() . '_' . preg_replace('/[^a-z0-9._-]/i', '_', basename($file['name']));
    $fileName = preg_replace('/\.[^.]+$/', '.jpg', $fileName);
    $destPath = rtrim($uploadDir, '/') . '/' . $fileName;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

    if (!resizeAndSave($file['tmp_name'], $mime, $destPath, 800, 800, 80)) {
        return ['error' => 'Failed to process image.'];
    }

    return ['location' => '/uploads/' . $fileName];
}

function resizeAndSave(string $src, string $mime, string $dest, int $maxW, int $maxH, int $quality): bool {
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

    // Preserve transparency for PNG
    if ($mime === 'image/png') {
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
        imagefill($resized, 0, 0, $transparent);
    } else {
        $white = imagecolorallocate($resized, 255, 255, 255); // White background for jpeg output
        imagefill($resized, 0, 0, $white);
    }

    imagecopyresampled($resized, $original, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
    $result = imagejpeg($resized, $dest, $quality);

    imagedestroy($original);
    imagedestroy($resized);

    return $result;
}
