<?php
class SecurityManager {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Session kontrolü yapar
     */
    public function checkSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Eğer kullanıcı giriş yapmamışsa ve login sayfasında değilse
        if (!isset($_SESSION['user_id']) && !$this->isLoginPage()) {
            header('Location: signin.php');
            exit;
        }
    }
    
    /**
     * Kullanıcının giriş yapıp yapmadığını kontrol eder
     */
    public function isLoggedIn() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Login sayfası kontrolü
     */
    private function isLoginPage() {
        $current_page = basename($_SERVER['PHP_SELF']);
        $login_pages = ['signin.php', 'signup.php', 'reset.php', 'install.php'];
        return in_array($current_page, $login_pages);
    }
    
    /**
     * Kullanıcı girişi
     */
    public function login($email, $password) {
        try {
            $user = $this->db->fetch("SELECT id, email, password_hash, name, surname FROM users WHERE email = ? AND is_active = 1", [$email]);
            
            if ($user && password_verify($password, $user['password_hash'])) {
                // Session başlat
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['full_name'] = trim($user['name'] . ' ' . $user['surname']);
                $_SESSION['login_time'] = time();
                
                // Login logu
                $this->logLogin($user['id'], 'success');
                
                // Update last login
                $this->db->execute("UPDATE users SET last_login = NOW() WHERE id = ?", [$user['id']]);
                
                return ['success' => true, 'user' => $user];
            } else {
                $this->logLogin($email, 'failed');
                return ['success' => false, 'message' => 'Geçersiz email veya şifre'];
            }
        } catch (Exception $e) {
            error_log('Login error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Sistem hatası'];
        }
    }
    
    /**
     * Kullanıcı çıkışı
     */
    public function logout() {
        if (isset($_SESSION['user_id'])) {
            $this->logLogin($_SESSION['user_id'], 'logout');
        }
        
        session_destroy();
        session_start();
        session_regenerate_id(true);
    }
    
    /**
     * Login logu
     */
    private function logLogin($identifier, $status) {
        try {
            $this->db->execute("
                INSERT INTO login_logs (identifier, status, ip_address, user_agent, created_at) 
                VALUES (?, ?, ?, ?, NOW())
            ", [
                $identifier,
                $status,
                $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
            ]);
        } catch (Exception $e) {
            error_log('Login log error: ' . $e->getMessage());
        }
    }
    
    /**
     * Rate limiting kontrolü
     */
    public function checkRateLimit($action, $limit = 5, $window = 300) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key = "rate_limit_{$action}_{$ip}";
        
        try {
            $result = $this->db->fetch("
                SELECT COUNT(*) as count FROM rate_limits 
                WHERE action = ? AND ip_address = ? AND created_at > DATE_SUB(NOW(), INTERVAL ? SECOND)
            ", [$action, $ip, $window]);
            
            if ($result['count'] >= $limit) {
                return false;
            }
            
            // Rate limit kaydı ekle
            $this->db->execute("
                INSERT INTO rate_limits (action, ip_address, created_at) 
                VALUES (?, ?, NOW())
            ", [$action, $ip]);
            
            return true;
        } catch (Exception $e) {
            error_log('Rate limit error: ' . $e->getMessage());
            return true; // Hata durumunda izin ver
        }
    }
    
    /**
     * Dosya upload güvenliği
     */
    public function validateFileUpload($file, $allowed_types = ['jpg', 'jpeg', 'png', 'gif'], $max_size = 5242880) {
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['valid' => false, 'message' => 'Dosya yükleme hatası'];
        }
        
        // Dosya boyutu kontrolü
        if ($file['size'] > $max_size) {
            return ['valid' => false, 'message' => 'Dosya boyutu çok büyük'];
        }
        
        // Dosya türü kontrolü
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $allowed_types)) {
            return ['valid' => false, 'message' => 'Geçersiz dosya türü'];
        }
        
        // MIME type kontrolü
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        $allowed_mimes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif'
        ];
        
        if (!isset($allowed_mimes[$extension]) || $allowed_mimes[$extension] !== $mime_type) {
            return ['valid' => false, 'message' => 'Geçersiz dosya içeriği'];
        }
        
        return ['valid' => true, 'message' => 'Dosya geçerli'];
    }
    
    /**
     * Güvenli dosya adı oluştur
     */
    public function generateSafeFileName($original_name) {
        $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        $safe_name = uniqid() . '_' . time() . '.' . $extension;
        return $safe_name;
    }
    
    /**
     * XSS koruması
     */
    public function sanitizeOutput($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitizeOutput'], $data);
        }
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * SQL injection koruması için prepared statement kullanımını zorunlu kıl
     */
    public function validateInput($data, $type = 'string') {
        switch ($type) {
            case 'email':
                return filter_var($data, FILTER_VALIDATE_EMAIL) ? $data : false;
            case 'int':
                return filter_var($data, FILTER_VALIDATE_INT) ? $data : false;
            case 'float':
                return filter_var($data, FILTER_VALIDATE_FLOAT) ? $data : false;
            case 'url':
                return filter_var($data, FILTER_VALIDATE_URL) ? $data : false;
            default:
                return strip_tags(trim($data));
        }
    }
    
    /**
     * Güvenlik başlıkları
     */
    public function setSecurityHeaders() {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Content-Security-Policy: default-src \'self\'; script-src \'self\' \'unsafe-inline\' \'unsafe-eval\'; style-src \'self\' \'unsafe-inline\'; img-src \'self\' data: https:; font-src \'self\' data:;');
    }
    
    /**
     * Kullanıcı yetkisi kontrolü
     */
    public function hasPermission($permission) {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        
        try {
            $stmt = $this->db->prepare("
                SELECT role FROM users WHERE id = ? AND status = 'active'
            ");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                return false;
            }
            
            // Basit rol tabanlı yetki sistemi
            $permissions = [
                'admin' => ['read', 'write', 'delete', 'admin'],
                'user' => ['read', 'write'],
                'guest' => ['read']
            ];
            
            $user_permissions = $permissions[$user['role']] ?? ['read'];
            return in_array($permission, $user_permissions);
            
        } catch (Exception $e) {
            error_log('Permission check error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * CSRF token doğrulama
     */
    public function validateCSRF($token) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * CSRF token oluştur
     */
    public function generateCSRF() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['csrf_token'];
    }
}
