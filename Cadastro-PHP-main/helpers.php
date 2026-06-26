<?php

function sessionStart(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

function flashSet(string $key, string $message): void {
    sessionStart();
    $_SESSION['flash'][$key] = $message;
}

function flashGet(string $key): string {
    sessionStart();
    $message = $_SESSION['flash'][$key] ?? '';
    unset($_SESSION['flash'][$key]);
    return $message;
}

function csrfToken(): string {
    sessionStart();
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

function verifyCsrfToken(?string $token): bool {
    sessionStart();
    return !empty($token) && hash_equals($_SESSION['_csrf_token'] ?? '', (string) $token);
}

function requireLogin(): void {
    sessionStart();
    if (!isset($_SESSION['usuario_id'])) {
        $_SESSION['redirect_pos_login'] = $_SERVER['PHP_SELF'];
        redirect('login.php');
    }
}

function getCurrentUser(PDO $pdo): ?array {
    sessionStart();
    if (empty($_SESSION['usuario_id'])) {
        return null;
    }

    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE id = :id');
    $stmt->execute([':id' => $_SESSION['usuario_id']]);
    return $stmt->fetch();
}

function requireAdmin(PDO $pdo): void {
    requireLogin();
    $usuario = getCurrentUser($pdo);

    if (!$usuario || (int) ($usuario['is_admin'] ?? 0) !== 1) {
        http_response_code(403);
        echo 'Acesso negado. Apenas administradores podem acessar esta página.';
        exit;
    }

    $_SESSION['usuario_is_admin'] = 1;
}

function old(string $field, string $default = ''): string {
    return htmlspecialchars($_POST[$field] ?? $default, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
