<?php

require_once __DIR__ . '/Database.php';

class Dashboard {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getDashboardStats() {
        return $this->db->fetch("
            SELECT 
                (SELECT SUM(e.amount) FROM expense_items e JOIN status_types s ON e.status_id = s.id WHERE s.name = 'Tamamlandı') as toplam_harcama,
                (SELECT SUM(e.amount) FROM expense_items e JOIN status_types s ON e.status_id = s.id WHERE s.name = 'Beklemede') as bekleyen_harcama,
                (SELECT SUM(p.amount) FROM payments p JOIN status_types s ON p.status_id = s.id WHERE s.name = 'Tamamlandı') as toplam_odeme,
                (SELECT SUM(p.amount) FROM payments p JOIN status_types s ON p.status_id = s.id WHERE s.name = 'Beklemede') as bekleyen_odeme,
                (SELECT total_balance FROM balances ORDER BY id DESC LIMIT 1) as mevcut_bakiye
        ");
    }

    public function getRecentTransactions() {
        $recent_transactions = $this->db->fetchAll("
            SELECT 'harcama' as tip, c.name as kategori, e.item_name as aciklama, e.amount as tutar, s.name as durum, e.created_at 
            FROM expense_items e 
            JOIN categories c ON e.category_id = c.id 
            JOIN status_types s ON e.status_id = s.id 
            ORDER BY e.created_at DESC LIMIT 5
        ");

        $recent_payments = $this->db->fetchAll("
            SELECT 'odeme' as tip, p.person_name as aciklama, p.amount as tutar, s.name as durum, p.created_at 
            FROM payments p 
            JOIN status_types s ON p.status_id = s.id 
            ORDER BY p.created_at DESC LIMIT 5
        ");

        $all_transactions = array_merge($recent_transactions, $recent_payments);
        usort($all_transactions, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return array_slice($all_transactions, 0, 10);
    }

    public function getCategoryExpenses() {
        return $this->db->fetchAll("
            SELECT c.name as kategori, SUM(e.amount) as toplam_tutar, COUNT(*) as islem_sayisi
            FROM expense_items e 
            JOIN categories c ON e.category_id = c.id 
            JOIN status_types s ON e.status_id = s.id 
            WHERE s.name = 'Tamamlandı'
            GROUP BY c.name 
            ORDER BY toplam_tutar DESC
        ");
    }
}
