<?php

require_once __DIR__ . '/../config/database.php';

class ActivityLog
{
    public static function record(string $actorType, int $actorId, string $action, string $description): void
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare(
            'INSERT INTO activity_logs (actor_type, actor_id, action, description)
             VALUES (:actor_type, :actor_id, :action, :description)'
        );
        $statement->execute([
            'actor_type' => $actorType,
            'actor_id' => $actorId,
            'action' => $action,
            'description' => $description,
        ]);
    }

    public static function recent(int $limit = 8): array
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare('SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT :limit');
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
