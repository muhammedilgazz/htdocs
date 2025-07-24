<?php

namespace App\Controllers;

use App\Models\Income;

class IncomeController {
    private $incomeModel;
    
    public function __construct(Income $incomeModel) {
        $this->incomeModel = $incomeModel;
    }
    
    /**
     * Tüm gelirler sayfası
     */
    public function index() {
        $userId = $_SESSION['user_id'] ?? 1; // Geçici olarak 1 kullanıyoruz
        $filter = $_GET['filter'] ?? 'all';
        
        $incomes = $this->incomeModel->getAllIncomes($userId, $filter) ?: [];
        $stats = $this->incomeModel->getIncomeStats($userId) ?: [];
        
        include ROOT_PATH . '/views/incomes/index.php';
    }
    
    /**
     * Sabit gelirler sayfası
     */
    public function fixed() {
        $userId = $_SESSION['user_id'] ?? 1;
        $incomes = $this->incomeModel->getAllIncomes($userId, 'fixed') ?: [];
        $stats = $this->incomeModel->getIncomeStats($userId) ?: [];
        
        include ROOT_PATH . '/views/incomes/fixed.php';
    }
    
    /**
     * Ekstra gelirler sayfası
     */
    public function extra() {
        $userId = $_SESSION['user_id'] ?? 1;
        $incomes = $this->incomeModel->getAllIncomes($userId, 'extra') ?: [];
        $stats = $this->incomeModel->getIncomeStats($userId) ?: [];
        
        include ROOT_PATH . '/views/incomes/extra.php';
    }
    
    /**
     * Gelir ekleme sayfası
     */
    public function create() {
        include ROOT_PATH . '/views/incomes/create.php';
    }
    
    /**
     * Gelir düzenleme sayfası
     */
    public function edit($id) {
        $userId = $_SESSION['user_id'] ?? 1;
        $income = $this->incomeModel->getIncomeById($id, $userId);
        
        if (!$income) {
            header('Location: /incomes');
            exit;
        }
        
        include ROOT_PATH . '/views/incomes/edit.php';
    }
    
    /**
     * Gelir silme işlemi
     */
    public function delete($id) {
        $userId = $_SESSION['user_id'] ?? 1;
        $result = $this->incomeModel->deleteIncome($id, $userId);
        
        if ($result) {
            $_SESSION['success_message'] = 'Gelir başarıyla silindi.';
        } else {
            $_SESSION['error_message'] = 'Gelir silinirken bir hata oluştu.';
        }
        
        header('Location: /incomes');
        exit;
    }
    
    /**
     * Gelir istatistikleri API
     */
    public function getStats() {
        $userId = $_SESSION['user_id'] ?? 1;
        $stats = $this->incomeModel->getIncomeStats($userId);
        $monthlySummary = $this->incomeModel->getMonthlyIncomeSummary($userId);
        
        json_response([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'monthly_summary' => $monthlySummary
            ]
        ]);
    }

    /**
     * AJAX: Yeni gelir ekleme
     * POST: title, currency, amount, period, receive_date, is_debt, description, csrf_token
     */
    public function ajax_add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }

        $userId = $_SESSION['user_id'] ?? 1; // Geçici olarak 1 kullanıyoruz
        $data = [
            'user_id' => $userId,
            'title' => sanitize_input($_POST['title'] ?? ''),
            'currency' => sanitize_input($_POST['currency'] ?? ''),
            'amount' => (float)($_POST['amount'] ?? 0),
            'period' => sanitize_input($_POST['period'] ?? ''),
            'receive_date' => sanitize_input($_POST['receive_date'] ?? ''),
            'is_debt' => isset($_POST['is_debt']) ? (int)sanitize_input($_POST['is_debt']) : 0,
            'description' => sanitize_input($_POST['description'] ?? ''),
            'status' => 'active'
        ];

        $result = $this->incomeModel->createIncome($data);

        if ($result) {
            return ['success' => true, 'message' => 'Gelir başarıyla eklendi.', 'income_id' => $result];
        } else {
            return ['success' => false, 'message' => 'Gelir eklenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Gelir bilgisi getirme
     * GET/POST: id, csrf_token
     */
    public function ajax_get() {
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        $csrf_token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? null;
        if (!isset($csrf_token) || !validate_csrf_token($csrf_token)) {
            return ['success' => false, 'message' => 'CSRF token geçersiz.'];
        }
        if (!isset($id) || !is_numeric($id)) {
            return ['success' => false, 'message' => 'Geçersiz gelir ID.'];
        }
        try {
            $userId = $_SESSION['user_id'] ?? 1;
            $income = $this->incomeModel->getIncomeById($id, $userId);
            if (!$income) {
                return ['success' => false, 'message' => 'Gelir bulunamadı.'];
            }
            return ['success' => true, 'data' => $income];
        } catch (\Exception $e) {
            error_log("Get income error: " . $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile());
            return ['success' => false, 'message' => 'Gelir bilgileri alınırken hata oluştu. Lütfen logları kontrol edin.'];
        }
    }

    /**
     * AJAX: Gelir güncelleme
     * POST: id, title, currency, amount, period, receive_date, is_debt, description, csrf_token
     */
    public function ajax_update() {
        if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
            return ['success' => false, 'message' => 'CSRF token geçersiz.'];
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Geçersiz istek metodu.'];
        }
        $required_fields = ['id', 'title', 'currency', 'amount', 'period', 'receive_date', 'is_debt'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || (empty($_POST[$field]) && $_POST[$field] !== '0')) {
                return ['success' => false, 'message' => "Lütfen tüm gerekli alanları doldurun. Eksik: $field"];
            }
        }
        if (!isset($_POST['id']) || !is_numeric($_POST['id']) || $_POST['id'] <= 0) {
            return ['success' => false, 'message' => 'Geçersiz gelir ID\'si.'];
        }
        try {
            $userId = $_SESSION['user_id'] ?? 1;
            $data = [
                'title' => trim($_POST['title']),
                'currency' => $_POST['currency'],
                'amount' => (float)$_POST['amount'],
                'period' => sanitize_input($_POST['period']),
                'receive_date' => sanitize_input($_POST['receive_date']),
                'is_debt' => sanitize_input($_POST['is_debt']) === 'yes' ? 1 : 0,
                'description' => sanitize_input($_POST['description'] ?? ''),
                'status' => 'active'
            ];
            if ($data['amount'] <= 0) {
                return ['success' => false, 'message' => 'Tutar 0\'dan büyük olmalıdır.'];
            }
            if (!in_array($data['currency'], ['TRY', 'USD', 'EUR', 'GBP'])) {
                return ['success' => false, 'message' => 'Geçersiz para birimi.'];
            }
            if (!in_array($data['period'], ['daily', 'weekly', 'monthly', 'yearly', 'one_time'])) {
                return ['success' => false, 'message' => 'Geçersiz periyot.'];
            }
            if (!in_array($data['is_debt'], [0, 1])) {
                return ['success' => false, 'message' => 'Geçersiz borç durumu.'];
            }
            $result = $this->incomeModel->updateIncome($_POST['id'], $userId, $data);
            if ($result) {
                return ['success' => true, 'message' => 'Gelir başarıyla güncellendi.'];
            } else {
                return ['success' => false, 'message' => 'Gelir güncellenirken bir hata oluştu.'];
            }
        } catch (\Exception $e) {
            error_log("Update income error: " . $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile());
            return ['success' => false, 'message' => 'Gelir güncellenirken bir hata oluştu. Lütfen logları kontrol edin.'];
        }
    }

    /**
     * AJAX: Gelir silme
     * POST: id, csrf_token
     */
    public function ajax_delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $userId = $_SESSION['user_id'] ?? 1;
        $incomeId = (int)($_POST['id'] ?? 0);
        $result = $this->incomeModel->deleteIncome($incomeId, $userId);
        if ($result) {
            return ['success' => true, 'message' => 'Gelir başarıyla silindi.'];
        } else {
            return ['success' => false, 'message' => 'Gelir silinirken bir hata oluştu.'];
        }
    }
}