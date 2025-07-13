<?php
/**
 * Bütçe Yönetim Sistemi - Kurulum Scripti
 * Bu script sistemi otomatik olarak kurar ve yapılandırır
 */

// Hata raporlamayı etkinleştir
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kurulum durumu kontrolü
if (file_exists('INSTALLED')) {
    die('Sistem zaten kurulmuş. Güvenlik için install.php dosyasını silin.');
}

$step = $_GET['step'] ?? 1;
$error = '';
$success = '';

// Form gönderildi mi?
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($step) {
        case 1:
            // Sistem gereksinimleri kontrolü
            $step = 2;
            break;
            
        case 2:
            // Veritabanı bağlantısı
            $db_host = $_POST['db_host'] ?? 'localhost';
            $db_name = $_POST['db_name'] ?? 'butce';
            $db_user = $_POST['db_user'] ?? '';
            $db_pass = $_POST['db_pass'] ?? '';
            
            try {
                $pdo = new PDO("mysql:host=$db_host", $db_user, $db_pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Veritabanını oluştur
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                $pdo->exec("USE `$db_name`");
                
                // Tabloları oluştur
                $sql_files = ['sql/create_tables.sql', 'sql/user_tables.sql'];
                foreach ($sql_files as $file) {
                    if (file_exists($file)) {
                        $sql = file_get_contents($file);
                        $pdo->exec($sql);
                    }
                }

                // Verileri ekle (DatabaseSeeder kullanarak)
                require_once 'classes/DatabaseSeeder.php';
                $seeder = new DatabaseSeeder($pdo);
                $seeder->seed();
                
                // Config dosyasını oluştur
                $config_content = "<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Güvenlik ayarları
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Session güvenliği
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset(\$_SERVER['HTTPS']) ? 1 : 0);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');

// CSRF token oluştur
if (!isset(\$_SESSION['csrf_token'])) {
    \$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Uygulama ayarları
define('APP_NAME', 'Bütçe Yönetim Sistemi');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://' . \$_SERVER['HTTP_HOST'] . dirname(\$_SERVER['PHP_SELF']) . '/');

// Veritabanı ayarları
define('DB_HOST', '$db_host');
define('DB_NAME', '$db_name');
define('DB_USER', '$db_user');
define('DB_PASS', '$db_pass');

// Cache ayarları
define('CACHE_ENABLED', true);
define('CACHE_DURATION', 300);

// Güvenlik fonksiyonları
function sanitize_input(\$data) {
    return htmlspecialchars(strip_tags(trim(\$data)), ENT_QUOTES, 'UTF-8');
}

function validate_csrf_token(\$token) {
    return isset(\$_SESSION['csrf_token']) && hash_equals(\$_SESSION['csrf_token'], \$token);
}

function generate_csrf_token() {
    return \$_SESSION['csrf_token'] ?? '';
}

function secure_redirect(\$url) {
    \$allowed_domains = [parse_url(BASE_URL, PHP_URL_HOST)];
    \$redirect_host = parse_url(\$url, PHP_URL_HOST);
    
    if (in_array(\$redirect_host, \$allowed_domains) || \$redirect_host === null) {
        header('Location: ' . \$url);
        exit;
    }
}

function log_security_event(\$event, \$details = []) {
    \$log_entry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => \$_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => \$_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
        'event' => \$event,
        'details' => \$details
    ];
    
    error_log('SECURITY: ' . json_encode(\$log_entry));
}

function is_ajax_request() {
    return isset(\$_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower(\$_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

function json_response(\$data, \$status = 200) {
    http_response_code(\$status);
    header('Content-Type: application/json');
    echo json_encode(\$data);
    exit;
}
?>";
                
                file_put_contents('config/config.php', $config_content);
                
                $success = 'Veritabanı başarıyla kuruldu!';
                $step = 3;
                
            } catch (Exception $e) {
                $error = 'Veritabanı hatası: ' . $e->getMessage();
            }
            break;
            
        case 3:
            // Admin kullanıcısı oluştur
            $admin_email = $_POST['admin_email'] ?? '';
            $admin_password = $_POST['admin_password'] ?? '';
            $admin_name = $_POST['admin_name'] ?? '';
            
            if (empty($admin_email) || empty($admin_password) || empty($admin_name)) {
                $error = 'Lütfen tüm alanları doldurun.';
            } else {
                try {
                    require_once 'config/config.php';
                    require_once 'classes/Database.php';
                    
                    $db = Database::getInstance();
                    $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
                    
                    $stmt = $db->prepare("
                        INSERT INTO users (email, password, full_name, role, status) 
                        VALUES (?, ?, ?, 'admin', 'active')
                    ");
                    $stmt->execute([$admin_email, $hashed_password, $admin_name]);
                    
                    $success = 'Admin kullanıcısı başarıyla oluşturuldu!';
                    $step = 4;
                    
                } catch (Exception $e) {
                    $error = 'Kullanıcı oluşturma hatası: ' . $e->getMessage();
                }
            }
            break;
            
        case 4:
            // Dizin izinleri ve son ayarlar
            $directories = ['uploads', 'backups', 'logs'];
            foreach ($directories as $dir) {
                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }
            }
            
            // Kurulum tamamlandı işareti
            file_put_contents('INSTALLED', date('Y-m-d H:i:s'));
            
            $success = 'Kurulum başarıyla tamamlandı!';
            $step = 5;
            break;
    }
}

// Sistem gereksinimleri kontrolü
function checkRequirements() {
    $requirements = [
        'PHP Version (>= 8.0)' => version_compare(PHP_VERSION, '8.0.0', '>='),
        'PDO Extension' => extension_loaded('pdo'),
        'PDO MySQL Extension' => extension_loaded('pdo_mysql'),
        'JSON Extension' => extension_loaded('json'),
        'cURL Extension' => extension_loaded('curl'),
        'config/ directory writable' => is_writable('config') || is_writable('.'),
        'uploads/ directory writable' => is_writable('uploads') || is_writable('.'),
        'logs/ directory writable' => is_writable('logs') || is_writable('.')
    ];
    
    return $requirements;
}

$requirements = checkRequirements();
$all_requirements_met = !in_array(false, $requirements);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurulum - Bütçe Yönetim Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .install-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin: 2rem;
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.5rem;
            font-weight: bold;
        }
        .step.active {
            background: #667eea;
            color: white;
        }
        .step.completed {
            background: #10b981;
            color: white;
        }
        .step.pending {
            background: #e5e7eb;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="install-container">
        <div class="p-4">
            <!-- Header -->
            <div class="text-center mb-4">
                <h2 class="mb-2">💰 Bütçe Yönetim Sistemi</h2>
                <p class="text-muted">Kurulum Sihirbazı</p>
            </div>
            
            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step <?= $step >= 1 ? 'active' : 'pending' ?>">1</div>
                <div class="step <?= $step >= 2 ? 'active' : ($step > 2 ? 'completed' : 'pending') ?>">2</div>
                <div class="step <?= $step >= 3 ? 'active' : ($step > 3 ? 'completed' : 'pending') ?>">3</div>
                <div class="step <?= $step >= 4 ? 'active' : ($step > 4 ? 'completed' : 'pending') ?>">4</div>
            </div>
            
            <!-- Messages -->
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
            
            <!-- Step Content -->
            <?php if ($step == 1): ?>
                <!-- Step 1: System Requirements -->
                <div class="mb-4">
                    <h4>1. Sistem Gereksinimleri</h4>
                    <p class="text-muted">Sistemin çalışması için gerekli olan bileşenler kontrol ediliyor...</p>
                </div>
                
                <div class="mb-4">
                    <?php foreach ($requirements as $requirement => $met): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><?= htmlspecialchars($requirement) ?></span>
                            <span class="badge bg-<?= $met ? 'success' : 'danger' ?>">
                                <i class="bi bi-<?= $met ? 'check' : 'x' ?>"></i>
                                <?= $met ? 'Tamam' : 'Hata' ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if ($all_requirements_met): ?>
                    <form method="POST" action="?step=1">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Devam Et <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Bazı sistem gereksinimleri karşılanmıyor. Lütfen eksik olan bileşenleri yükleyin.
                    </div>
                <?php endif; ?>
                
            <?php elseif ($step == 2): ?>
                <!-- Step 2: Database Configuration -->
                <div class="mb-4">
                    <h4>2. Veritabanı Yapılandırması</h4>
                    <p class="text-muted">MySQL veritabanı bağlantı bilgilerini girin.</p>
                </div>
                
                <form method="POST" action="?step=2">
                    <div class="mb-3">
                        <label for="db_host" class="form-label">Veritabanı Sunucusu</label>
                        <input type="text" class="form-control" id="db_host" name="db_host" 
                               value="localhost" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="db_name" class="form-label">Veritabanı Adı</label>
                        <input type="text" class="form-control" id="db_name" name="db_name" 
                               value="butce" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="db_user" class="form-label">Veritabanı Kullanıcısı</label>
                        <input type="text" class="form-control" id="db_user" name="db_user" 
                               placeholder="root" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="db_pass" class="form-label">Veritabanı Şifresi</label>
                        <input type="password" class="form-control" id="db_pass" name="db_pass">
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Veritabanını Kur <i class="bi bi-database ms-2"></i>
                        </button>
                    </div>
                </form>
                
            <?php elseif ($step == 3): ?>
                <!-- Step 3: Admin User -->
                <div class="mb-4">
                    <h4>3. Admin Kullanıcısı</h4>
                    <p class="text-muted">Sistem yöneticisi hesabını oluşturun.</p>
                </div>
                
                <form method="POST" action="?step=3">
                    <div class="mb-3">
                        <label for="admin_name" class="form-label">Ad Soyad</label>
                        <input type="text" class="form-control" id="admin_name" name="admin_name" 
                               placeholder="Admin User" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="admin_email" class="form-label">E-posta Adresi</label>
                        <input type="email" class="form-control" id="admin_email" name="admin_email" 
                               placeholder="admin@example.com" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="admin_password" class="form-label">Şifre</label>
                        <input type="password" class="form-control" id="admin_password" name="admin_password" 
                               placeholder="Güçlü bir şifre girin" required>
                        <div class="form-text">En az 8 karakter, büyük/küçük harf, rakam ve özel karakter içermeli.</div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Admin Hesabı Oluştur <i class="bi bi-person-plus ms-2"></i>
                        </button>
                    </div>
                </form>
                
            <?php elseif ($step == 4): ?>
                <!-- Step 4: Final Setup -->
                <div class="mb-4">
                    <h4>4. Son Ayarlar</h4>
                    <p class="text-muted">Dizin izinleri ve güvenlik ayarları yapılandırılıyor...</p>
                </div>
                
                <form method="POST" action="?step=4">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Kurulumu Tamamla <i class="bi bi-check-circle ms-2"></i>
                        </button>
                    </div>
                </form>
                
            <?php elseif ($step == 5): ?>
                <!-- Step 5: Installation Complete -->
                <div class="text-center">
                    <div class="mb-4">
                        <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h4 class="mb-3">🎉 Kurulum Tamamlandı!</h4>
                    <p class="text-muted mb-4">
                        Bütçe Yönetim Sistemi başarıyla kuruldu. Artık sistemi kullanmaya başlayabilirsiniz.
                    </p>
                    
                    <div class="alert alert-info">
                        <strong>Güvenlik Notu:</strong> Güvenlik için install.php dosyasını silin.
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="signin.php" class="btn btn-primary">
                            Giriş Yap <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="index.php" class="btn btn-outline-secondary">
                            Dashboard'a Git <i class="bi bi-house ms-2"></i>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>