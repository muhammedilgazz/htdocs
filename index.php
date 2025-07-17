<?php

require_once __DIR__ . '/bootstrap.php';

// Auth sınıfını bootstrap.php içinde başlattığımız için burada tekrar yapmıyoruz.
// Ancak Auth objesine ihtiyacımız varsa, global olarak erişilebilir olmalı veya yeniden oluşturulmalı.
// Şimdilik basitlik adına burada yeniden oluşturuyorum, ancak daha iyi bir yaklaşım dependency injection olabilir.
// Test betiği çalışırken kimlik doğrulama adımını atla
if (!defined('RUNNING_TESTS')) {
    $auth = new \App\Models\Auth();
    $auth->requireAuth();
}

// Basic Routing
$base_path = parse_url(BASE_URL, PHP_URL_PATH);
$request_uri = $_SERVER['REQUEST_URI'];

// Remove the base path from the request URI
if (substr($request_uri, 0, strlen($base_path)) == $base_path) {
    $request_path = substr($request_uri, strlen($base_path));
} else {
    $request_path = $request_uri;
}
// Query string'i ayıkla
$request_path = explode('?', $request_path, 2)[0];
$request_path = trim($request_path, '/');
$segments = explode('/', $request_path);

// If the first segment is the script name, treat it as the root
if (isset($segments[0]) && strtolower($segments[0]) === 'index.php') {
    $segments[0] = '';
}

// Handle special routes
$route_mappings = [
    'accountpassword' => 'AccountPasswordController',
    'account-password' => 'AccountPasswordController',
    'hesap-sifre' => 'AccountPasswordController',
    'need' => 'NeedController',
    'needs' => 'NeedController',
    'ihtiyac' => 'NeedController',
    'ihtiyaclar' => 'NeedController',
    // Gider ve harcama controller mappingleri:
    'expenses' => 'ExpenseController',
    'fixedexpense' => 'FixedExpenseController',
    'variableexpense' => 'VariableExpenseController',
    'extraexpense' => 'ExtraExpenseController',
    'postponedpayment' => 'PostponedPaymentController',
    'giderler' => 'GiderlerController',
    'tax' => 'TaxController',
    'sgk' => 'SgkController',
    'bank' => 'BankController',
    'execution' => 'ExecutionController',
    'individualdebt' => 'IndividualDebtController',
    'wishlist' => 'WishlistController',
    'project' => 'ProjectController',
    'task' => 'TaskController',
    'note' => 'NoteController',
    'todolist' => 'TodoListController',
    'bankaccount' => 'BankAccountController',
    'profile' => 'ProfileController',
    'settings' => 'SettingsController',
    'support' => 'SupportController',
    'affiliate' => 'AffiliateController',
    'privacy' => 'PrivacyController',
    'dreamgoal' => 'DreamGoalController',
    'favoriteproduct' => 'FavoriteProductController'
];

$controller_name_segment = $segments[0] ?? '';
$controller_class_name = null;
$method_name = 'index';

if (isset($route_mappings[$controller_name_segment])) {
    $controller_class_name = $route_mappings[$controller_name_segment];
    if (isset($segments[1]) && !empty($segments[1])) {
        $method_name = $segments[1];
    }
} else {
    // Handle camelCase controllers (e.g., fixedExpense -> FixedExpenseController)
    $controller_class_name = ucfirst($controller_name_segment) . 'Controller';
    if (isset($segments[1]) && !empty($segments[1])) {
        $method_name = $segments[1];
    }
}

// Default to DashboardController if no segment or mapping found
if (empty($controller_class_name) || !class_exists('\\App\\Controllers\\' . $controller_class_name)) {
    $controller_class_name = 'DashboardController';
}

$full_controller_class = '\\App\\Controllers\\' . $controller_class_name;

if (!class_exists($full_controller_class)) {
    // Handle 404 - Controller not found
    http_response_code(404);
    echo "404 - Controller not found: " . $full_controller_class;
    exit;
}

$controller = new $full_controller_class();
if (!method_exists($controller, $method_name)) {
    // Handle 404 - Method not found
    http_response_code(404);
    echo "404 - Method not found in controller: " . $controller_class_name . "::" . $method_name;
    exit;
}

$controller->$method_name();