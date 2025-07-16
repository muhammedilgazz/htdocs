<?php

namespace App\Models;

use App\Models\Database;
use PDO;
use DateTime;
use Exception;

class Auth {
    private $db;
    private $maxAttempts = 5;
    private $lockoutTime = 900; // 15 minutes
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function login($username, $password) {
        $stmt = $this->db->getPdo()->prepare("SELECT id, username, password_hash, full_name, failed_attempts, locked_until FROM users WHERE username = ? AND is_active = 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            return false;
        }
        
        if ($user['locked_until'] && new DateTime() < new DateTime($user['locked_until'])) {
            throw new Exception('Hesabınız geçici olarak kilitlenmiştir. Lütfen daha sonra tekrar deneyin.');
        }
        
        if (password_verify($password, $user['password_hash'])) {
            $this->resetFailedAttempts($user['id']);
            $this->createSession($user['id'], $user['username'], $user['full_name']);
            return true;
        } else {
            $this->incrementFailedAttempts($user['id']);
            return false;
        }
    }
    
    private function createSession($userId, $username, $full_name) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['full_name'] = $full_name; // full_name'i session'a ekle
        $_SESSION['login_time'] = time();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        
        // Update last login
        $stmt = $this->db->getPdo()->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        $stmt->execute([$userId]);
    }
    
    public function isLoggedIn() {
        if (!isset($_SESSION['user_id'])) return false;
        
        // Check session timeout (24 hours)
        if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > 86400) {
            $this->logout();
            return false;
        }
        
        return true;
    }
    
    public function logout() {
        session_destroy();
    }
    
    public function requireAuth() {
        if (!$this->isLoggedIn()) {
            header('Location: signin.php');
            exit;
        }
    }
    
    private function incrementFailedAttempts($userId) {
        $stmt = $this->db->getPdo()->prepare("UPDATE users SET failed_attempts = failed_attempts + 1, locked_until = CASE WHEN failed_attempts >= ? THEN DATE_ADD(NOW(), INTERVAL ? SECOND) ELSE NULL END WHERE id = ?");
        $stmt->execute([$this->maxAttempts - 1, $this->lockoutTime, $userId]);
    }
    
    private function resetFailedAttempts($userId) {
        $stmt = $this->db->getPdo()->prepare("UPDATE users SET failed_attempts = 0, locked_until = NULL WHERE id = ?");
        $stmt->execute([$userId]);
    }
    
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function getUsername() {
        return $_SESSION['username'] ?? null;
    }
    
    public function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }
}