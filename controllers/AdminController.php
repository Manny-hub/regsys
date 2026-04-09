<?php

require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Registration.php';
require_once __DIR__ . '/../models/ActivityLog.php';

class AdminController
{
    public static function getDashboardData(): array
    {
        $topCourses = Registration::getTopCourses();
        $registrationTrend = Registration::getDailyRegistrationTrend();
        $unitDistribution = Registration::getUnitDistribution();
        $conversionRate = Student::countAll() > 0
            ? round((Registration::countAll() / Student::countAll()), 1)
            : 0;

        return [
            'totalStudents' => Student::countAll(),
            'totalCourses' => Course::countAll(),
            'totalRegistrations' => Registration::countAll(),
            'avgRegistrationsPerStudent' => $conversionRate,
            'topCourses' => $topCourses,
            'registrationTrend' => $registrationTrend,
            'unitDistribution' => $unitDistribution,
            'recentActivities' => ActivityLog::recent(),
        ];
    }

    public static function saveCourse(array $input, int $adminId, ?int $courseId = null): array
    {
        $courseName = trim($input['course_name'] ?? '');
        $courseCode = strtoupper(trim($input['course_code'] ?? ''));
        $unit = (int) ($input['unit'] ?? 0);

        if ($courseName === '' || $courseCode === '' || $unit <= 0) {
            return ['success' => false, 'message' => 'Course name, code, and a valid unit are required.'];
        }

        if (strlen($courseName) < 3) {
            return ['success' => false, 'message' => 'Course name must be at least 3 characters long.'];
        }

        if (!preg_match('/^[A-Z]{2,10}[0-9]{1,5}$/', $courseCode)) {
            return ['success' => false, 'message' => 'Course code must look like CSC101 or MTH204.'];
        }

        if ($unit > 10) {
            return ['success' => false, 'message' => 'Credit unit must be between 1 and 10.'];
        }

        $existingCourse = Course::findByCode($courseCode);
        if ($existingCourse && (int) $existingCourse['id'] !== (int) $courseId) {
            return ['success' => false, 'message' => 'A course with this code already exists.'];
        }

        if ($courseId) {
            Course::update($courseId, $courseName, $courseCode, $unit);
            ActivityLog::record('admin', $adminId, 'course_update', "Updated course {$courseCode}.");

            return ['success' => true, 'message' => 'Course updated successfully.'];
        }

        Course::create($courseName, $courseCode, $unit);
        ActivityLog::record('admin', $adminId, 'course_create', "Created course {$courseCode}.");

        return ['success' => true, 'message' => 'Course added successfully.'];
    }

    public static function deleteCourse(int $courseId, int $adminId): array
    {
        $course = Course::findById($courseId);

        if (!$course) {
            return ['success' => false, 'message' => 'Course not found.'];
        }

        Course::delete($courseId);
        ActivityLog::record('admin', $adminId, 'course_delete', "Deleted course {$course['course_code']}.");

        return ['success' => true, 'message' => 'Course deleted successfully.'];
    }
}
