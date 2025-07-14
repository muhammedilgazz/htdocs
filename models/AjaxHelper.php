<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/SecurityManager.php';

/**
 * Handles common logic for AJAX requests, including security checks and response handling.
 *
 * @param callable $callback The function to execute if all security checks pass. 
 *                           This function receives the sanitized POST data as an argument.
 */
function handle_ajax_request(callable $callback) {
    ob_start(); // Start output buffering
    header('Content-Type: application/json');

    try {
        $security = new SecurityManager();

        if (!$security->isLoggedIn()) {
            ob_clean(); // Clean any buffered output
            json_response(['success' => false, 'message' => 'Oturum açmanız gerekiyor'], 401);
        }

        if (!is_ajax_request()) {
            ob_clean(); // Clean any buffered output
            json_response(['success' => false, 'message' => 'Geçersiz istek'], 400);
        }

        if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
            ob_clean(); // Clean any buffered output
            json_response(['success' => false, 'message' => 'CSRF token geçersiz'], 403);
        }

        // Sanitize all POST data
        $sanitized_data = [];
        foreach ($_POST as $key => $value) {
            $sanitized_data[$key] = sanitize_input($value);
        }

        // Execute the specific logic for the request
        $callback($sanitized_data);

    } catch (Exception $e) {
        error_log('AJAX Request Error: ' . $e->getMessage());
        ob_clean(); // Clean any buffered output
        json_response(['success' => false, 'message' => 'Bir sistem hatası oluştu.'], 500);
    }
}

/**
 * Handles common logic for GET AJAX requests.
 *
 * @param callable $callback The function to execute if all security checks pass.
 */
function handle_get_request(callable $callback) {
    ob_start(); // Start output buffering
    header('Content-Type: application/json');

    try {
        $security = new SecurityManager();

        if (!$security->isLoggedIn()) {
            ob_clean(); // Clean any buffered output
            json_response(['success' => false, 'message' => 'Oturum açmanız gerekiyor'], 401);
        }

        if (!is_ajax_request()) {
            ob_clean(); // Clean any buffered output
            json_response(['success' => false, 'message' => 'Geçersiz istek'], 400);
        }

        // Sanitize all GET data
        $sanitized_data = [];
        foreach ($_GET as $key => $value) {
            $sanitized_data[$key] = sanitize_input($value);
        }

        $callback($sanitized_data);

    } catch (Exception $e) {
        error_log('AJAX GET Request Error: ' . $e->getMessage());
        ob_clean(); // Clean any buffered output
        json_response(['success' => false, 'message' => 'Bir sistem hatası oluştu.'], 500);
    }
}
