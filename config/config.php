<?php
// Session güvenliği - session başlamadan önce ayarla
if (session_status() == PHP_SESSION_NONE) {
    // Session ayarlarını yalnızca headers gönderilmemişse ayarla
    if (!headers_sent()) {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
        ini_set('session.use_strict_mode', 1);
        ini_set('session.cookie_samesite', 'Strict');
        session_start();
    }
}

// Güvenlik ayarları
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// CSRF token oluştur
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Uygulama ayarları
define('APP_NAME', 'Bütçe Yönetim Sistemi');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://localhost/');
define('ROOT_PATH', dirname(__DIR__));

// Load environment variables
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Veritabanı ayarları
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'budget_db');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');

// Cache ayarları
define('CACHE_ENABLED', true);
define('CACHE_DURATION', 300); // 5 dakika

// Güvenlik fonksiyonları
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function generate_csrf_token() {
    return $_SESSION['csrf_token'] ?? '';
}

function secure_redirect($url) {
    $allowed_domains = [parse_url(BASE_URL, PHP_URL_HOST)];
    $redirect_host = parse_url($url, PHP_URL_HOST);
    
    if (in_array($redirect_host, $allowed_domains) || $redirect_host === null) {
        header('Location: ' . $url);
        exit;
    }
}

function log_security_event($event, $details = []) {
    $log_entry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
        'event' => $event,
        'details' => $details
    ];
    
    error_log('SECURITY: ' . json_encode($log_entry));
}

function is_ajax_request() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

function json_response($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    $json_output = json_encode($data);
    // Log the JSON output to a file for debugging
    file_put_contents(__DIR__ . '/../logs/json_response_debug.log', "\n---" . date('Y-m-d H:i:s') . "---\n" . $json_output, FILE_APPEND);
    echo $json_output;
    exit;
}

// Ay yardımcı fonksiyonlarını dahil et

?>