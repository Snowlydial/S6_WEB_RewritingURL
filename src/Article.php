<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/Util.php';

class Article {

    public static function findAll(): array {
        $stmt = getDb()->query('SELECT * FROM article ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array {
        $stmt = getDb()->prepare('SELECT * FROM article WHERE id_article = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findBySlug(string $slug): ?array {
        $stmt = getDb()->prepare('SELECT * FROM article WHERE slug = ?');
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function save(array $data): int {
        $db = getDb();

        $title   = $data['title'] ?? '';
        $slug    = generateSlug($title);
        $content = $data['content'] ?? '';
        $authors = $data['authors'] ?? '';
        $summary = !empty($data['summary'])
            ? $data['summary']
            : generateSummary($title, $content);

        $id = isset($data['id']) && (int)$data['id'] > 0 ? (int)$data['id'] : null;

        $coverPath = null;

        if (!empty($_FILES['cover']) && $_FILES['cover']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadDir = __DIR__ . '/../public/uploads/cover/';
            $result = uploadImage($_FILES['cover'], $uploadDir);

            if (!empty($result['error'])) {
                throw new \Exception($result['error']);
            }

            $coverPath = $result['location'];
        }

        if ($id) {
            $existing = self::findById($id);

            if (!$coverPath) { // garder ancien cover si pas upload
                $coverPath = $existing['cover'] ?? null;
            }

            $stmt = $db->prepare('
                UPDATE article
                SET title = ?, slug = ?, content = ?, summary = ?, authors = ?, cover = ?
                WHERE id_article = ?
            ');
            $stmt->execute([$title, $slug, $content, $summary, $authors, $coverPath, $id]);

            return $id;

        } else {
            $stmt = $db->prepare('
                INSERT INTO article (title, slug, content, summary, authors, cover, created_at)
                VALUES (?, ?, ?, ?, ?, ?, UTC_TIMESTAMP())
            ');
            $stmt->execute([$title, $slug, $content, $summary, $authors, $coverPath]);

            return (int) $db->lastInsertId();
        }
    }

    public static function delete(int $id): void {
        $stmt = getDb()->prepare('DELETE FROM article WHERE id_article = ?');
        $stmt->execute([$id]);
    }
}
