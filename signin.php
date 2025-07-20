<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/bootstrap.php';

$auth = new \App\Models\Auth();

// Çıkış işlemi
if (isset($_GET['logout'])) {
    $auth->logout();
    header('Location: signin.php');
    exit;
}

// Zaten giriş yapmışsa dashboard'a yönlendir
if ($auth->isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error_message = '';
$success_message = '';

// Login form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_input($_POST['username'] ?? ''); // Kullanıcı adı olarak email kullanılıyor
    $password = $_POST['password'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';

    if (!validate_csrf_token($csrf_token)) {
        $error_message = 'CSRF hatası. Lütfen sayfayı yenileyin ve tekrar deneyin.';
    } elseif (empty($username) || empty($password)) {
        $error_message = 'Lütfen tüm alanları doldurun.';
        error_log("Login attempt: Empty username or password.");
    } else {
        try {
            if ($auth->login($username, $password)) {
                header('Location: index.php');
                exit;
            } else {
                $error_message = 'Geçersiz kullanıcı adı veya şifre.';
                error_log("Login attempt failed for username: " . $username . " - Invalid credentials.");
            }
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            error_log("Login attempt failed for username: " . $username . " - Exception: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - <?= APP_NAME ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/custom-colors.css" rel="stylesheet">
    
    <style>
        body {
            background: #f5f7fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .auth-wrapper {
            display: flex;
            flex-direction: row;
            background: none;
            border-radius: 16px;
            max-width: 900px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 2px 16px 0 rgba(79,140,255,0.06);
        }
        .auth-info {
            flex: 1 1 0;
            background: linear-gradient(135deg, #4f8cff 0%, #6c2bd7 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            padding: 2.5rem 2rem 2rem 2.5rem;
            min-width: 280px;
            color: #fff;
            position: relative;
        }
        .auth-info .logo {
            margin-bottom: 2.5rem;
            margin-top: 0.5rem;
        }
        .auth-info .logo img {
            height: 38px;
        }
        .auth-info .welcome {
            margin-bottom: 2.5rem;
        }
        .auth-info h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.5rem;
        }
        .auth-info p {
            font-size: 1.1rem;
            color: #e5e9f2;
            margin-bottom: 0;
        }
        .auth-info .socials {
            display: flex;
            gap: 1.2rem;
            margin-bottom: 1.5rem;
        }
        .auth-info .socials a {
            color: #fff;
            opacity: 0.85;
            font-size: 1.25rem;
            transition: opacity 0.2s;
        }
        .auth-info .socials a:hover {
            opacity: 1;
        }
        .auth-info .links {
            font-size: 0.97rem;
            color: #e5e9f2;
            margin-bottom: 0.2rem;
        }
        .auth-info .links a {
            color: #fff;
            text-decoration: underline;
            margin-right: 1.2rem;
            opacity: 0.9;
            font-size: 0.97rem;
        }
        .auth-login {
            flex: 1 1 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2.5rem 2.5rem;
            min-width: 340px;
            background: #fff;
            border-radius: 0 16px 16px 0;
        }
        .login-container {
            background: none;
            border-radius: 0;
            box-shadow: none;
            width: 100%;
            max-width: 340px;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-header {
            width: 100%;
            text-align: left;
            margin-bottom: 1.5rem;
        }
        .login-header h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #222;
        }
        .login-body {
            width: 100%;
        }
        .form-label {
            font-size: 0.95rem;
            color: #374151;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #e5e9f2;
            padding: 0.7rem 0.9rem;
            font-size: 1rem;
            background: #f9fafb;
            color: #222;
            margin-bottom: 1rem;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: #4f8cff;
            background: #fff;
            outline: none;
            box-shadow: none;
        }
        .input-group-text {
            background: #f5f7fa;
            border: none;
            color: #8b95a1;
            font-size: 1.1rem;
        }
        .btn-primary {
            background: #3a32e2;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.8rem 0;
            width: 100%;
            font-weight: 700;
            font-size: 1.08rem;
            box-shadow: none;
            transition: background 0.2s;
            margin-top: 0.5rem;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: #2a1dbb;
            color: #fff;
        }
        .form-check-input:checked {
            background-color: #4f8cff;
            border-color: #4f8cff;
        }
        .alert {
            border-radius: 8px;
            border: none;
            font-size: 0.97rem;
            margin-bottom: 1rem;
        }
        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #8b95a1;
            cursor: pointer;
            font-size: 1.1rem;
        }
        .password-toggle:hover {
            color: #2563eb;
        }
        .login-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.97rem;
            color: #6b7280;
        }
        .login-footer a {
            color: #3a32e2;
            text-decoration: underline;
            margin-left: 0.3rem;
            font-weight: 500;
        }
        @media (max-width: 900px) {
            .auth-wrapper {
                flex-direction: column;
                max-width: 98vw;
            }
            .auth-info, .auth-login {
                min-width: 0;
                width: 100%;
                padding: 2rem 1rem;
                border-radius: 0;
            }
            .auth-info {
                align-items: center;
            text-align: center;
                border-radius: 16px 16px 0 0;
            }
            .auth-login {
                border-radius: 0 0 16px 16px;
        }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-info">
            <div class="logo">
                <img src="assets/images/logo-white.png" alt="Logo">
            </div>
            <div class="welcome">
                <h1>Xtreme <br>Yönetim Paneli</h1>
            </div>
            <div class="socials">
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-x"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
                <a href="#"><i class="bi bi-pinterest"></i></a>
            </div>
            <div class="links">
                <a href="#">2 adımlı doğrulama ile ilgili sorun mu var?</a><br>
                <a href="#">Gizlilik Politikası</a>
            </div>
        </div>
        <div class="auth-login">
    <div class="login-container">
        <div class="login-header">
                    <h4>Giriş Yap</h4>
        </div>
        <div class="login-body">
            <?php if ($error_message): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            <?php if ($success_message): ?>
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>
            <form method="POST" id="loginForm">
                <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                <div class="mb-3">
                            <label for="username" class="form-label">Kullanıcı Adı</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" 
                               placeholder="Kullanıcı adınızı girin" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <div class="input-group position-relative">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Şifrenizi girin" required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye" id="passwordIcon"></i>
                        </button>
                    </div>
                </div>
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Beni hatırla
                        </label>
                    </div>
                            <a href="#" class="text-decoration-none" style="font-size:0.97rem; color:#3a32e2; font-weight:500;">Şifremi Unuttum</a>
                </div>
                    <button type="submit" class="btn btn-primary" id="loginBtn">
                        <span id="loginText">Giriş Yap</span>
                            <span id="loginLoading" style="display:none;"><span class="spinner-border spinner-border-sm"></span> Giriş yapılıyor...</span>
                    </button>
                    </form>
                    <div class="login-footer">
                        Hesabınız yok mu?
                        <a href="signup.php">Kayıt Ol</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Şifre göster/gizle
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');
            }
        }
        
        // Form submit
        // Form submit - Disable button and show spinner
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loginBtn = document.getElementById('loginBtn');
            const loginText = document.getElementById('loginText');
            const loginLoading = document.getElementById('loginLoading');
            
            loginText.style.display = 'none';
            loginLoading.style.display = 'inline-block';
            loginBtn.disabled = true; // Butonu devre dışı bırak
        });
        
        // Enter tuşu ile giriş
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('loginForm').submit();
            }
        });
        
        // Auto focus username field
        document.getElementById('username').focus();
    </script>
</body>
</html>