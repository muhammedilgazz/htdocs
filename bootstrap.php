<?php
/**
 * Bootstrap dosyası - Tüm sayfalarda yüklenecek
 */

// Session başlat
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Config yükle
require_once __DIR__ . '/config/config.php';

// Güvenlik kontrolleri
$security = SecurityManager::getInstance();

// Rate limiting (sadece POST istekleri için)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $security->rateLimit($_SERVER['REMOTE_ADDR']);
}

// CSRF token kontrolü (POST/PUT/DELETE için)
if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT', 'DELETE'])) {
    if (!isset($_POST['csrf_token'])) {
        http_response_code(403);
        die('CSRF token missing');
    }
    $security->validateCSRF($_POST['csrf_token']);
}

// Input sanitization
if (!empty($_POST)) {
    $_POST = $security->sanitizeInput($_POST);
}
if (!empty($_GET)) {
    $_GET = $security->sanitizeInput($_GET);
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
?>