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

        if ($id) {
            // Fetch existing created_at so we don't overwrite it
            $existing = self::findById($id);
            $createdAt = $existing['created_at'] ?? date('Y-m-d H:i:s');

            $stmt = $db->prepare('
                UPDATE article
                SET title = ?, slug = ?, content = ?, summary = ?, authors = ?
                WHERE id_article = ?
            ');
            $stmt->execute([$title, $slug, $content, $summary, $authors, $id]);
            return $id;
        } else {
            $stmt = $db->prepare('
                INSERT INTO article (title, slug, content, summary, authors, created_at)
                VALUES (?, ?, ?, ?, ?, UTC_TIMESTAMP())
            ');
            $stmt->execute([$title, $slug, $content, $summary, $authors]);
            return (int) $db->lastInsertId();
        }
    }

    public static function delete(int $id): void {
        $stmt = getDb()->prepare('DELETE FROM article WHERE id_article = ?');
        $stmt->execute([$id]);
    }
}
