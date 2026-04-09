<?php

require_once __DIR__ . '/../config/database.php';

class Student
{
    public static function create(string $name, string $email, string $password): int
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare(
            'INSERT INTO students (name, email, password) VALUES (:name, :email, :password)'
        );
        $statement->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        return (int) $pdo->lastInsertId();
    }

    public static function findByEmail(string $email): ?array
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare('SELECT * FROM students WHERE email = :email LIMIT 1');
        $statement->execute(['email' => $email]);
        $student = $statement->fetch();

        return $student ?: null;
    }

    public static function findById(int $id): ?array
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare('SELECT * FROM students WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        $student = $statement->fetch();

        return $student ?: null;
    }

    public static function countAll(): int
    {
        $pdo = Database::getConnection();
        return (int) $pdo->query('SELECT COUNT(*) FROM students')->fetchColumn();
    }

    public static function getAllWithRegistrationCount(): array
    {
        $pdo = Database::getConnection();
        $sql = 'SELECT s.id, s.name, s.email, s.created_at, COUNT(r.id) AS registered_courses
                FROM students s
                LEFT JOIN registrations r ON r.student_id = s.id
                GROUP BY s.id, s.name, s.email, s.created_at
                ORDER BY s.created_at DESC';

        return $pdo->query($sql)->fetchAll();
    }
}
