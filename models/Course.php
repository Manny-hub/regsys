<?php

require_once __DIR__ . '/../config/database.php';

class Course
{
    public static function countAll(string $search = ''): int
    {
        $pdo = Database::getConnection();

        if ($search !== '') {
            $statement = $pdo->prepare(
                'SELECT COUNT(*) FROM courses
                 WHERE course_name LIKE :search OR course_code LIKE :search'
            );
            $statement->execute(['search' => '%' . $search . '%']);

            return (int) $statement->fetchColumn();
        }

        return (int) $pdo->query('SELECT COUNT(*) FROM courses')->fetchColumn();
    }

    public static function getPaginated(string $search, int $limit, int $offset): array
    {
        $pdo = Database::getConnection();
        $sql = 'SELECT * FROM courses';
        $params = [];

        if ($search !== '') {
            $sql .= ' WHERE course_name LIKE :search OR course_code LIKE :search';
            $params['search'] = '%' . $search . '%';
        }

        $sql .= ' ORDER BY course_code ASC LIMIT :limit OFFSET :offset';

        $statement = $pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $statement->bindValue(':' . $key, $value, PDO::PARAM_STR);
        }

        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getAll(): array
    {
        $pdo = Database::getConnection();
        return $pdo->query('SELECT * FROM courses ORDER BY course_code ASC')->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare('SELECT * FROM courses WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        $course = $statement->fetch();

        return $course ?: null;
    }

    public static function findByCode(string $courseCode): ?array
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare('SELECT * FROM courses WHERE course_code = :course_code LIMIT 1');
        $statement->execute(['course_code' => $courseCode]);
        $course = $statement->fetch();

        return $course ?: null;
    }

    public static function create(string $courseName, string $courseCode, int $unit): int
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare(
            'INSERT INTO courses (course_name, course_code, unit) VALUES (:course_name, :course_code, :unit)'
        );
        $statement->execute([
            'course_name' => $courseName,
            'course_code' => $courseCode,
            'unit' => $unit,
        ]);

        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, string $courseName, string $courseCode, int $unit): bool
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare(
            'UPDATE courses
             SET course_name = :course_name, course_code = :course_code, unit = :unit
             WHERE id = :id'
        );

        return $statement->execute([
            'course_name' => $courseName,
            'course_code' => $courseCode,
            'unit' => $unit,
            'id' => $id,
        ]);
    }

    public static function delete(int $id): bool
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare('DELETE FROM courses WHERE id = :id');
        return $statement->execute(['id' => $id]);
    }
}
