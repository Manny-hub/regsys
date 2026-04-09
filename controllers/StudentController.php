<?php

require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Registration.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/ActivityLog.php';

class StudentController
{
    public static function getDashboardData(int $studentId): array
    {
        $student = Student::findById($studentId);

        return [
            'student' => $student,
            'registeredCourses' => Registration::countForStudent($studentId),
            'currentUnits' => Registration::getStudentTotalUnits($studentId),
            'availableCourses' => Course::countAll(),
            'courses' => Registration::getStudentCourses($studentId),
        ];
    }

    public static function getCoursePageData(int $studentId, string $search, int $page, int $perPage): array
    {
        $totalCourses = Course::countAll($search);
        $totalPages = max((int) ceil($totalCourses / $perPage), 1);
        $page = min($page, $totalPages);
        $courses = Course::getPaginated($search, $perPage, paginate_offset($page, $perPage));
        $registeredIds = Registration::getRegisteredCourseIds($studentId);
        $currentUnits = Registration::getStudentTotalUnits($studentId);

        return [
            'courses' => $courses,
            'registeredIds' => $registeredIds,
            'currentUnits' => $currentUnits,
            'registeredCount' => Registration::countForStudent($studentId),
            'totalCourses' => $totalCourses,
            'totalPages' => $totalPages,
            'page' => $page,
            'search' => $search,
        ];
    }

    public static function registerCourse(int $studentId, int $courseId): array
    {
        $course = Course::findById($courseId);

        if (!$course) {
            return ['success' => false, 'message' => 'Selected course was not found.'];
        }

        if (Registration::exists($studentId, $courseId)) {
            return ['success' => false, 'message' => 'You are already registered for this course.'];
        }

        $currentUnits = Registration::getStudentTotalUnits($studentId);
        $newTotalUnits = $currentUnits + (int) $course['unit'];

        if ($newTotalUnits > MAX_CREDIT_UNITS) {
            return [
                'success' => false,
                'message' => 'Course registration exceeds the maximum credit limit of ' . MAX_CREDIT_UNITS . ' units.',
            ];
        }

        Registration::create($studentId, $courseId);

        $student = Student::findById($studentId);
        ActivityLog::record(
            'student',
            $studentId,
            'course_register',
            "{$student['name']} registered for {$course['course_code']}."
        );

        return [
            'success' => true,
            'message' => 'Course registered successfully.',
            'currentUnits' => $newTotalUnits,
            'registeredCount' => Registration::countForStudent($studentId),
        ];
    }

    public static function dropCourse(int $studentId, int $courseId): array
    {
        $course = Course::findById($courseId);

        if (!$course) {
            return ['success' => false, 'message' => 'Selected course was not found.'];
        }

        if (!Registration::exists($studentId, $courseId)) {
            return ['success' => false, 'message' => 'You are not registered for this course.'];
        }

        Registration::deleteByStudentCourse($studentId, $courseId);
        $student = Student::findById($studentId);
        $currentUnits = Registration::getStudentTotalUnits($studentId);

        ActivityLog::record(
            'student',
            $studentId,
            'course_drop',
            "{$student['name']} dropped {$course['course_code']}."
        );

        return [
            'success' => true,
            'message' => 'Course dropped successfully.',
            'currentUnits' => $currentUnits,
            'registeredCount' => Registration::countForStudent($studentId),
        ];
    }
}
