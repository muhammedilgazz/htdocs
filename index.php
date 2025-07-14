<?php
require_once 'config/config.php';
require_once 'models/AuthManager.php';

$auth = new AuthManager();
$auth->checkSession();

// Autoload controllers
spl_autoload_register(function ($class_name) {
    $controller_path = 'controllers/' . $class_name . '.php';
    if (file_exists($controller_path)) {
        require_once $controller_path;
    }
});

// Basic Routing
$base_path = parse_url(BASE_URL, PHP_URL_PATH);
$request_uri = $_SERVER['REQUEST_URI'];

// Remove the base path from the request URI
if (substr($request_uri, 0, strlen($base_path)) == $base_path) {
    $request_path = substr($request_uri, strlen($base_path));
} else {
    $request_path = $request_uri;
}

$request_path = trim($request_path, '/');
$segments = explode('/', $request_path);

// If the first segment is the script name, treat it as the root
if (isset($segments[0]) && strtolower($segments[0]) === 'index.php') {
    $segments[0] = '';
}

$controller_name = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'DashboardController';
$method_name = isset($segments[1]) && !empty($segments[1]) ? $segments[1] : 'index';

// Debugging output
// echo "Base Path: $base_path <br>";
// echo "Request URI: $request_uri <br>";
// echo "Request Path: $request_path <br>";
// echo "Controller: $controller_name <br>";
// echo "Method: $method_name <br>";

if (class_exists($controller_name)) {
    $controller = new $controller_name();
    if (method_exists($controller, $method_name)) {
        $controller->$method_name();
    } else {
        // Handle 404 - Method not found
        echo "404 - Method not found";
    }
} else {
    // Handle 404 - Controller not found
    echo "404 - Controller not found: $controller_name";
}