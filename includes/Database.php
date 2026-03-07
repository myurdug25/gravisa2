<?php
/**
 * Veritabanı bağlantısı ve talep kayıt/liste
 */

class Database
{
    private static $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            self::$pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$pdo;
    }

    public static function saveSubmission(string $type, array $data): string
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $pdo = self::getConnection();
        $stmt = $pdo->prepare('INSERT INTO talepler (tip, veri, created_at) VALUES (?, ?, ?)');
        $stmt->execute([$type, json_encode($data, JSON_UNESCAPED_UNICODE), $data['created_at']]);
        return $type . '_' . $pdo->lastInsertId();
    }

    /**
     * Belirli tipteki talepleri listeler (en yeni önce)
     * @return array [ id => veri_array, ... ]
     */
    public static function getSubmissions(string $type): array
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare('SELECT id, veri, created_at FROM talepler WHERE tip = ? ORDER BY id DESC');
        $stmt->execute([$type]);
        $items = [];
        while ($row = $stmt->fetch()) {
            $data = json_decode($row['veri'], true) ?: [];
            $data['created_at'] = $row['created_at'];
            $items[$type . '_' . $row['id']] = $data;
        }
        return $items;
    }

    /** Tek bir talebi ID ile getirir (tip_id formatında) */
    public static function getSubmissionById(string $id): ?array
    {
        $parts = explode('_', $id, 2);
        if (count($parts) !== 2 || !is_numeric($parts[1])) {
            return null;
        }
        $type = $parts[0];
        $numId = (int)$parts[1];
        $pdo = self::getConnection();
        $stmt = $pdo->prepare('SELECT id, veri, created_at FROM talepler WHERE id = ? AND tip = ?');
        $stmt->execute([$numId, $type]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        $data = json_decode($row['veri'], true) ?: [];
        $data['created_at'] = $row['created_at'];
        return $data;
    }

    /** Talebin veri alanını günceller (cevap vb.) */
    public static function updateSubmission(string $id, array $data): bool
    {
        $parts = explode('_', $id, 2);
        if (count($parts) !== 2 || !is_numeric($parts[1])) {
            return false;
        }
        $type = $parts[0];
        $numId = (int)$parts[1];
        $pdo = self::getConnection();
        $stmt = $pdo->prepare('UPDATE talepler SET veri = ?, created_at = created_at WHERE id = ? AND tip = ?');
        return $stmt->execute([json_encode($data, JSON_UNESCAPED_UNICODE), $numId, $type]);
    }

    /** Talebi tamamen siler */
    public static function deleteSubmission(string $id): bool
    {
        $parts = explode('_', $id, 2);
        if (count($parts) !== 2 || !is_numeric($parts[1])) {
            return false;
        }
        $type = $parts[0];
        $numId = (int)$parts[1];
        $pdo = self::getConnection();
        $stmt = $pdo->prepare('DELETE FROM talepler WHERE id = ? AND tip = ?');
        return $stmt->execute([$numId, $type]);
    }
}
