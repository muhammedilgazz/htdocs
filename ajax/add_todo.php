<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/config/config.php';
use App\Models\Todo;
use App\Models\Database; // Database sınıfını dahil et

require_once ROOT_PATH . '/config/config.php'; // config.php'yi buraya taşıdık, çünkü ROOT_PATH'i kullanıyor
// require_once ROOT_PATH . '/app/Models/Todo.php'; // Zaten use ile belirtildi
// require_once ROOT_PATH . '/app/Models/Database.php'; // Zaten use ile belirtildi

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek!']);
    exit;
}

$task = trim($_POST['task'] ?? '');
$due_date = $_POST['due_date'] ?? null; // due_date'i al

if ($task === '') {
    echo json_encode(['success' => false, 'message' => 'Görev boş olamaz!']);
    exit;
}

try {
    $db = Database::getInstance(); // Singleton veritabanı bağlantısını kullan
    $todo_model = new App\Models\Todo($db); // Todo modelini başlat

    $data = [
        'task' => $task,
        'status' => 'Beklemede', // Varsayılan durum
        'due_date' => $due_date // due_date'i ekle
    ];

    if ($todo_model->add($data)) {
        echo json_encode(['success' => true, 'message' => 'Görev başarıyla eklendi.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Görev eklenirken bir hata oluştu.']);
    }
} catch (Exception $e) {
    error_log("Add Todo Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Veritabanı hatası!']);
}