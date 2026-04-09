<?php

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header("Location: {$path}");
    exit;
}

function set_flash(string $type, string $message): void
{
    $_SESSION['flash_messages'][] = [
        'type' => $type,
        'message' => $message,
    ];
}

function get_flash_messages(): array
{
    $messages = $_SESSION['flash_messages'] ?? [];
    unset($_SESSION['flash_messages']);

    return $messages;
}

function store_old_input(array $data): void
{
    $filtered = array_filter($data, static function ($value) {
        return is_scalar($value);
    });

    unset($filtered['password'], $filtered['confirm_password'], $filtered['csrf_token']);

    $_SESSION['old_input'] = $filtered;
}

function clear_old_input(): void
{
    unset($_SESSION['old_input']);
}

function old(string $key, string $default = ''): string
{
    return e($_SESSION['old_input'][$key] ?? $default);
}

function is_post_request(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function is_student_logged_in(): bool
{
    return !empty($_SESSION['student_id']);
}

function is_admin_logged_in(): bool
{
    return !empty($_SESSION['admin_id']);
}

function require_student_auth(): void
{
    if (!is_student_logged_in()) {
        set_flash('danger', 'Please log in as a student to continue.');
        redirect('student_login.php');
    }
}

function require_admin_auth(): void
{
    if (!is_admin_logged_in()) {
        set_flash('danger', 'Please log in as an administrator to continue.');
        redirect('admin_login.php');
    }
}

function current_student_id(): ?int
{
    return isset($_SESSION['student_id']) ? (int) $_SESSION['student_id'] : null;
}

function current_admin_id(): ?int
{
    return isset($_SESSION['admin_id']) ? (int) $_SESSION['admin_id'] : null;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf_token(?string $token): bool
{
    return !empty($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function validate_csrf_or_fail(?string $token): void
{
    if (!verify_csrf_token($token)) {
        set_flash('danger', 'Invalid request token. Please try again.');
        redirect($_SERVER['HTTP_REFERER'] ?? 'index.php');
    }
}

function json_response(array $data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function current_page(): int
{
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    return max($page, 1);
}

function paginate_offset(int $page, int $perPage): int
{
    return ($page - 1) * $perPage;
}
