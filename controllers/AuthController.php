<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Util.php';

function handleLogin(): void {
    verifyCsrf();

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        redirect('/login?error=1');
    }

    $stmt = getDb()->prepare('
        SELECT u.id_user, u.username, u.password, r.label AS role
        FROM user u
        LEFT JOIN role r ON u.id_role = r.id_role
        WHERE u.username = ?
    ');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    $isValid = false;
    if ($user) {
        $storedPassword = (string) $user['password'];

        // Accept both secure hashes and legacy plaintext passwords.
        if (password_verify($password, $storedPassword)) {
            $isValid = true;
        } elseif (hash_equals($storedPassword, $password)) {
            $isValid = true;

            // Upgrade plaintext password to a secure hash after successful login.
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $upgradeStmt = getDb()->prepare('UPDATE user SET password = ? WHERE id_user = ?');
            $upgradeStmt->execute([$newHash, $user['id_user']]);
        }
    }

    if (!$isValid) {
        redirect('/login?error=1');
    }

    sessionStart();
    session_regenerate_id(true);
    $_SESSION['user_id']  = $user['id_user'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role']     = $user['role'];

    redirect('/article/list');
}

function handleLogout(): void {
    sessionStart();
    session_destroy();
    redirect('/login');
}
