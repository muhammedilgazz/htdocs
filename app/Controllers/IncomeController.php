<?php

namespace App\Controllers;

use App\Models\Income;

class IncomeController {
    private $incomeModel;
    
    public function __construct() {
        $this->incomeModel = new Income();
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
} 