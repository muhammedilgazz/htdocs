<?php
/**
 * Bootstrap dosyası - Tüm sayfalarda yüklenecek
 */

// Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Dependency Injection Container'ı başlat
$container = require_once __DIR__ . '/app/container_bindings.php';

// Session başlat
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_samesite', 'Strict');
    session_start();
}

// Config yükle (içinde sanitize_input ve generate_csrf_token var)
require_once __DIR__ . '/config/config.php';

// Auth sınıfını dahil et
// Auth sınıfı artık Composer autoloader tarafından yüklenecek, doğrudan require_once gerekmez.
// require_once __DIR__ . '/models/Auth.php';

// CSRF token kontrolü (POST/PUT/DELETE için)
if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT', 'DELETE'])) {
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        http_response_code(403);
        die('CSRF token missing or invalid');
    }
}

// Input sanitization
if (!empty($_POST)) {
    $_POST = sanitize_input($_POST);
}
if (!empty($_GET)) {
    $_GET = sanitize_input($_GET);
}

// Error handling
set_error_handler(function($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    
    $error = [
        'severity' => $severity,
        'message' => $message,
        'file' => $file,
        'line' => $line,
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ];
    
    error_log('ERROR: ' . json_encode($error));
    
    if ($severity === E_ERROR || $severity === E_USER_ERROR) {
        header('Location: 500.php');
        exit;
    }
    
    return true;
});

// Exception handler
set_exception_handler(function($exception) {
    error_log('EXCEPTION: ' . $exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine());
    header('Location: 500.php');
    exit;
});