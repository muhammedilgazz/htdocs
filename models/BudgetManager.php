<?php
require_once 'Database.php';

class BudgetManager {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getExpenses($cache = true) {
        $cache_key = $cache ? 'expenses' : null;
        return $this->db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id ORDER BY ei.order_number", [], $cache_key);
    }
    
    public function getPayments($cache = true) {
        $cache_key = $cache ? 'payments' : null;
        return $this->db->fetchAll("SELECT p.*, st.name as status_name FROM payments p JOIN status_types st ON p.status_id = st.id WHERE p.amount > 0 ORDER BY p.id", [], $cache_key);
    }
    
    public function getWishlist($cache = true) {
        $cache_key = $cache ? 'wishlist' : null;
        return $this->db->fetchAll("SELECT wi.*, c.name as category_name FROM wishlist_items wi JOIN categories c ON wi.category_id = c.id ORDER BY wi.id", [], $cache_key);
    }
    
    public function getIbanInfo($cache = true) {
        $cache_key = $cache ? 'iban_info' : null;
        return $this->db->fetchAll("SELECT id.*, b.name as bank_name FROM iban_details id JOIN banks b ON id.bank_id = b.id ORDER BY id.id", [], $cache_key);
    }
    
    public function getAccountPasswords($cache = true) {
        $cache_key = $cache ? 'account_passwords' : null;
        return $this->db->fetchAll("SELECT ac.*, at.name as account_type_name FROM account_credentials ac JOIN account_types at ON ac.account_type_id = at.id ORDER BY ac.id", [], $cache_key);
    }
    
    public function getTotalExpenses() {
        $result = $this->db->fetchAll("SELECT SUM(amount) as total FROM expense_items", [], 'total_expenses');
        return $result[0]['total'] ?? 0;
    }
    
    public function getTotalPayments() {
        $result = $this->db->fetchAll("SELECT SUM(amount) as total FROM payments WHERE status_id != (SELECT id FROM status_types WHERE name = 'Ödendi')", [], 'total_payments');
        return $result[0]['total'] ?? 0;
    }
    
    public function getTotalWishlist() {
        $result = $this->db->fetchAll("SELECT SUM(price) as total FROM wishlist_items WHERE will_get = TRUE", [], 'total_wishlist');
        return $result[0]['total'] ?? 0;
    }
    
    public function updatePaymentStatus($id, $status) {
        // Get valid status names from the database
        $valid_statuses_query = $this->db->fetchAll("SELECT name FROM status_types");
        $valid_statuses = array_column($valid_statuses_query, 'name');

        if (!in_array($status, $valid_statuses)) {
            throw new InvalidArgumentException('Geçersiz durum');
        }
        
        return $this->db->execute("UPDATE payments SET status_id = (SELECT id FROM status_types WHERE name = ?) WHERE id = ?", [$status, $id]);
    }
    
    public function getDbValue($query, $default = 0) {
        try {
            $result = $this->db->fetchAll($query);
            return $result[0] ? array_values($result[0])[0] : $default;
        } catch(Exception $e) {
            return $default;
        }
    }
    
    public function formatCurrency($amount) {
        return '₺' . number_format($amount, 0, ',', '.');
    }
}
