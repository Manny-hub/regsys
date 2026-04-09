<?php

require_once __DIR__ . '/../config/database.php';

class Registration
{
    public static function countAll(): int
    {
        $pdo = Database::getConnection();
        return (int) $pdo->query('SELECT COUNT(*) FROM registrations')->fetchColumn();
    }

    public static function countForStudent(int $studentId): int
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare('SELECT COUNT(*) FROM registrations WHERE student_id = :student_id');
        $statement->execute(['student_id' => $studentId]);

        return (int) $statement->fetchColumn();
    }

    public static function getRegisteredCourseIds(int $studentId): array
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare('SELECT course_id FROM registrations WHERE student_id = :student_id');
        $statement->execute(['student_id' => $studentId]);

        return array_map('intval', array_column($statement->fetchAll(), 'course_id'));
    }

    public static function getStudentCourses(int $studentId): array
    {
        $pdo = Database::getConnection();
        $sql = 'SELECT c.*, r.id AS registration_id
                FROM registrations r
                INNER JOIN courses c ON c.id = r.course_id
                WHERE r.student_id = :student_id
                ORDER BY c.course_code ASC';
        $statement = $pdo->prepare($sql);
        $statement->execute(['student_id' => $studentId]);

        return $statement->fetchAll();
    }

    public static function getStudentTotalUnits(int $studentId): int
    {
        $pdo = Database::getConnection();
        $sql = 'SELECT COALESCE(SUM(c.unit), 0)
                FROM registrations r
                INNER JOIN courses c ON c.id = r.course_id
                WHERE r.student_id = :student_id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['student_id' => $studentId]);

        return (int) $statement->fetchColumn();
    }

    public static function exists(int $studentId, int $courseId): bool
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare(
            'SELECT COUNT(*) FROM registrations WHERE student_id = :student_id AND course_id = :course_id'
        );
        $statement->execute([
            'student_id' => $studentId,
            'course_id' => $courseId,
        ]);

        return (int) $statement->fetchColumn() > 0;
    }

    public static function create(int $studentId, int $courseId): bool
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare(
            'INSERT INTO registrations (student_id, course_id) VALUES (:student_id, :course_id)'
        );

        return $statement->execute([
            'student_id' => $studentId,
            'course_id' => $courseId,
        ]);
    }

    public static function deleteByStudentCourse(int $studentId, int $courseId): bool
    {
        $pdo = Database::getConnection();
        $statement = $pdo->prepare(
            'DELETE FROM registrations WHERE student_id = :student_id AND course_id = :course_id'
        );

        return $statement->execute([
            'student_id' => $studentId,
            'course_id' => $courseId,
        ]);
    }

    public static function getAllDetailed(): array
    {
        $pdo = Database::getConnection();
        $sql = 'SELECT r.id, s.name AS student_name, s.email, c.course_name, c.course_code, c.unit, r.created_at
                FROM registrations r
                INNER JOIN students s ON s.id = r.student_id
                INNER JOIN courses c ON c.id = r.course_id
                ORDER BY r.created_at DESC';

        return $pdo->query($sql)->fetchAll();
    }

    public static function getTopCourses(int $limit = 5): array
    {
        $pdo = Database::getConnection();
        $sql = 'SELECT c.course_code, c.course_name, COUNT(r.id) AS total
                FROM courses c
                LEFT JOIN registrations r ON r.course_id = c.id
                GROUP BY c.id, c.course_code, c.course_name
                ORDER BY total DESC, c.course_code ASC
                LIMIT :limit';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getDailyRegistrationTrend(int $days = 7): array
    {
        $pdo = Database::getConnection();
        $startDate = date('Y-m-d', strtotime('-' . ($days - 1) . ' days'));
        $sql = 'SELECT DATE(created_at) AS day, COUNT(*) AS total
                FROM registrations
                WHERE DATE(created_at) >= :start_date
                GROUP BY DATE(created_at)
                ORDER BY day ASC';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':start_date', $startDate, PDO::PARAM_STR);
        $statement->execute();
        $rows = $statement->fetchAll();

        $indexedRows = [];
        foreach ($rows as $row) {
            $indexedRows[$row['day']] = (int) $row['total'];
        }

        $trend = [];
        for ($offset = $days - 1; $offset >= 0; $offset--) {
            $date = date('Y-m-d', strtotime("-{$offset} days"));
            $trend[] = [
                'label' => date('M d', strtotime($date)),
                'total' => $indexedRows[$date] ?? 0,
            ];
        }

        return $trend;
    }

    public static function getUnitDistribution(): array
    {
        $pdo = Database::getConnection();
        $sql = 'SELECT c.unit, COUNT(r.id) AS total
                FROM courses c
                LEFT JOIN registrations r ON r.course_id = c.id
                GROUP BY c.unit
                ORDER BY c.unit ASC';

        return $pdo->query($sql)->fetchAll();
    }
}
