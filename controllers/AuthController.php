<?php

require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/ActivityLog.php';

class AuthController
{
    public static function registerStudent(array $input): array
    {
        $name = trim($input['name'] ?? '');
        $email = strtolower(trim($input['email'] ?? ''));
        $password = $input['password'] ?? '';
        $confirmPassword = $input['confirm_password'] ?? '';

        if ($name === '' || $email === '' || $password === '' || $confirmPassword === '') {
            return ['success' => false, 'message' => 'All fields are required.'];
        }

        if (strlen($name) < 3) {
            return ['success' => false, 'message' => 'Full name must be at least 3 characters long.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Please enter a valid email address.'];
        }

        if (strlen($password) < 6) {
            return ['success' => false, 'message' => 'Password must be at least 6 characters long.'];
        }

        if ($password !== $confirmPassword) {
            return ['success' => false, 'message' => 'Password confirmation does not match.'];
        }

        if (Student::findByEmail($email)) {
            return ['success' => false, 'message' => 'An account with this email already exists.'];
        }

        $studentId = Student::create($name, $email, password_hash($password, PASSWORD_DEFAULT));
        ActivityLog::record('student', $studentId, 'student_register', "{$name} created a student account.");

        return ['success' => true, 'message' => 'Account created successfully. Please log in.'];
    }

    public static function loginStudent(array $input): array
    {
        $email = strtolower(trim($input['email'] ?? ''));
        $password = $input['password'] ?? '';

        if ($email === '' || $password === '') {
            return ['success' => false, 'message' => 'Email and password are required.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Please enter a valid email address.'];
        }

        $student = Student::findByEmail($email);

        if (!$student || !password_verify($password, $student['password'])) {
            return ['success' => false, 'message' => 'Invalid student login credentials.'];
        }

        session_regenerate_id(true);
        $_SESSION['student_id'] = (int) $student['id'];
        $_SESSION['student_name'] = $student['name'];

        ActivityLog::record('student', (int) $student['id'], 'student_login', "{$student['name']} logged in.");

        return ['success' => true, 'message' => 'Login successful.'];
    }

    public static function loginAdmin(array $input): array
    {
        $username = trim($input['username'] ?? '');
        $password = $input['password'] ?? '';

        if ($username === '' || $password === '') {
            return ['success' => false, 'message' => 'Username and password are required.'];
        }

        if (strlen($username) < 3) {
            return ['success' => false, 'message' => 'Username must be at least 3 characters long.'];
        }

        $admin = Admin::findByUsername($username);

        if (!$admin || !password_verify($password, $admin['password'])) {
            return ['success' => false, 'message' => 'Invalid admin login credentials.'];
        }

        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int) $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];

        ActivityLog::record('admin', (int) $admin['id'], 'admin_login', "{$admin['username']} logged in.");

        return ['success' => true, 'message' => 'Admin login successful.'];
    }
}
