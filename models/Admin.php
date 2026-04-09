<?php

require_once __DIR__ . '/../config/database.php';

class Admin
{
    public static function findByUsername(string $username): ?array
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare('SELECT * FROM admins WHERE username = :username LIMIT 1');
        $statement->execute(['username' => $username]);
        $admin = $statement->fetch();

        return $admin ?: null;
    }

    public static function countAll(): int
    {
        $pdo = Database::getConnection();
        return (int) $pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn();
    }
}
