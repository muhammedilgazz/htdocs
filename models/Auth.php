<?php
class Auth {
    private $pdo;
    private $maxAttempts = 5;
    private $lockoutTime = 900; // 15 minutes
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function login($username, $password) {
        if ($this->isRateLimited($_SERVER['REMOTE_ADDR'], 'login')) {
            throw new Exception('Too many login attempts. Please try again later.');
        }
        
        $stmt = $this->pdo->prepare("SELECT id, username, password_hash, failed_attempts, locked_until FROM users WHERE username = ? AND is_active = 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if (!$user) {
            $this->recordFailedAttempt($_SERVER['REMOTE_ADDR'], 'login');
            return false;
        }
        
        if ($user['locked_until'] && new DateTime() < new DateTime($user['locked_until'])) {
            throw new Exception('Account is temporarily locked.');
        }
        
        if (password_verify($password, $user['password_hash'])) {
            $this->resetFailedAttempts($user['id']);
            $this->createSession($user['id'], $user['username']);
            return true;
        } else {
            $this->incrementFailedAttempts($user['id']);
            $this->recordFailedAttempt($_SERVER['REMOTE_ADDR'], 'login');
            return false;
        }
    }
    
    private function createSession($userId, $username) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = time();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        
        // Store session in database
        $sessionId = session_id();
        $stmt = $this->pdo->prepare("INSERT INTO user_sessions (id, user_id, ip_address, user_agent, expires_at) VALUES (?, ?, ?, ?, DATE_ADD(NOW(), INTERVAL 24 HOUR))");
        $stmt->execute([$sessionId, $userId, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'] ?? '']);
        
        // Update last login
        $stmt = $this->pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
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
        if (isset($_SESSION['user_id'])) {
            $stmt = $this->pdo->prepare("DELETE FROM user_sessions WHERE id = ?");
            $stmt->execute([session_id()]);
        }
        session_destroy();
    }
    
    public function requireAuth() {
        if (!$this->isLoggedIn()) {
            header('Location: signin.php');
            exit;
        }
    }
    
    private function isRateLimited($ip, $endpoint) {
        $stmt = $this->pdo->prepare("SELECT attempts FROM rate_limits WHERE ip_address = ? AND endpoint = ? AND window_start > DATE_SUB(NOW(), INTERVAL 15 MINUTE)");
        $stmt->execute([$ip, $endpoint]);
        $result = $stmt->fetch();
        
        return $result && $result['attempts'] >= 10;
    }
    
    private function recordFailedAttempt($ip, $endpoint) {
        $stmt = $this->pdo->prepare("INSERT INTO rate_limits (ip_address, endpoint, attempts, window_start) VALUES (?, ?, 1, NOW()) ON DUPLICATE KEY UPDATE attempts = attempts + 1");
        $stmt->execute([$ip, $endpoint]);
    }
    
    private function incrementFailedAttempts($userId) {
        $stmt = $this->pdo->prepare("UPDATE users SET failed_attempts = failed_attempts + 1, locked_until = CASE WHEN failed_attempts >= ? THEN DATE_ADD(NOW(), INTERVAL ? SECOND) ELSE NULL END WHERE id = ?");
        $stmt->execute([$this->maxAttempts - 1, $this->lockoutTime, $userId]);
    }
    
    private function resetFailedAttempts($userId) {
        $stmt = $this->pdo->prepare("UPDATE users SET failed_attempts = 0, locked_until = NULL WHERE id = ?");
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
