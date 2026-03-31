<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (!empty($extraHead)): ?>
        <?= $extraHead ?>
    <?php endif; ?>
    <title><?= e($pageTitle ?? 'IranInfo') ?> — IranInfo</title>
    <link rel="stylesheet" href="/css/base.css">
    <?php if (!empty($extraCss)): ?>
        <?php foreach ($extraCss as $css): ?>
            <link rel="stylesheet" href="/css/<?= e($css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (!empty($extraHead)): ?>
        <?= $extraHead ?>
    <?php endif; ?>
</head>

<body>