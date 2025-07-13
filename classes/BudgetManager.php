<?php
require_once 'Database.php';

class BudgetManager {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getExpenses($cache = true) {
        $cache_key = $cache ? 'expenses' : null;
return $this->db->query("SELECT * FROM harcama_kalemleri ORDER BY sira", [], $cache_key);
    }
    
    public function getPayments($cache = true) {
        $cache_key = $cache ? 'payments' : null;
        return $this->db->query("SELECT * FROM odemeler WHERE tutar > 0 ORDER BY id", [], $cache_key);
    }
    
    public function getWishlist($cache = true) {
        $cache_key = $cache ? 'wishlist' : null;
        return $this->db->query("SELECT * FROM istek_listesi ORDER BY id", [], $cache_key);
    }
    
    public function getIbanInfo($cache = true) {
        $cache_key = $cache ? 'iban_info' : null;
        return $this->db->query("SELECT * FROM iban_bilgileri ORDER BY id", [], $cache_key);
    }
    
    public function getAccountPasswords($cache = true) {
        $cache_key = $cache ? 'account_passwords' : null;
        return $this->db->query("SELECT * FROM hesaplar_sifreler ORDER BY id", [], $cache_key);
    }
    
    public function getTotalExpenses() {
        $result = $this->db->query("SELECT SUM(tutar) as total FROM harcama_kalemleri", [], 'total_expenses');
        return $result[0]['total'] ?? 0;
    }
    
    public function getTotalPayments() {
        $result = $this->db->query("SELECT SUM(tutar) as total FROM odemeler WHERE durum != 'Ödendi'", [], 'total_payments');
        return $result[0]['total'] ?? 0;
    }
    
    public function getTotalWishlist() {
        $result = $this->db->query("SELECT SUM(fiyat) as total FROM istek_listesi WHERE will_get = 'yes'", [], 'total_wishlist');
        return $result[0]['total'] ?? 0;
    }
    
    public function updatePaymentStatus($id, $status) {
        $valid_statuses = ['Beklemede', 'Gecikmiş', 'Planlandı', 'Ödendi'];
        if (!in_array($status, $valid_statuses)) {
            throw new InvalidArgumentException('Geçersiz durum');
        }
        
        return $this->db->execute("UPDATE odemeler SET durum = ? WHERE id = ?", [$status, $id]);
    }
    
    public function getDbValue($query, $default = 0) {
        try {
            $result = $this->db->query($query);
            return $result[0] ? array_values($result[0])[0] : $default;
        } catch(Exception $e) {
            return $default;
        }
    }
    
    public function formatCurrency($amount) {
        return '₺' . number_format($amount, 0, ',', '.');
    }
}
