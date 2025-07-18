<?php

namespace App\Models;

use App\Models\Database;
use DateTime;

class Expense {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir gider ekler.
     *
     * @param array $data Gider verileri (amount, category_type, description, date).
     * @return bool Başarı durumu.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO expenses (amount, category_type, description, date) VALUES (?, ?, ?, ?)";
        $params = [
            $data['amount'],
            $data['category_type'],
            $data['description'] ?? null,
            $data['date'] ?? date('Y-m-d')
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir gideri ID'sine göre günceller.
     *
     * @param int $id Güncellenecek giderin ID'si.
     * @param array $data Yeni gider verileri.
     * @return bool Başarı durumu.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE expenses SET amount = ?, category_type = ?, description = ?, date = ? WHERE id = ?";
        $params = [
            $data['amount'],
            $data['category_type'],
            $data['description'] ?? null,
            $data['date'] ?? date('Y-m-d'),
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir gideri ID'sine göre siler.
     *
     * @param int $id Silinecek giderin ID'si.
     * @return bool Başarı durumu.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM expenses WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Bir gideri ID'sine göre getirir.
     *
     * @param int $id Gider ID'si.
     * @return array|false Gider verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM expenses WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }

    /**
     * Tüm giderleri veya belirli bir kategoriye göre giderleri getirir.
     *
     * @param string|null $category_type Filtrelemek için kategori tipi.
     * @return array Giderler listesi.
     */
    public function getAll(?string $category_type = null): array {
        $sql = "SELECT * FROM expenses";
        $params = [];
        if ($category_type) {
            $sql .= " WHERE category_type = ?";
            $params[] = $category_type;
        }
        $sql .= " ORDER BY date DESC";
        return $this->db->fetchAll($sql, $params);
    }

    /**
     * Belirtilen ayın toplam giderini hesaplar.
     *
     * @param string $month 'Y-m' formatında ay.
     * @return float Toplam gider.
     */
    public function getTotalForMonth(string $month): float {
        $sql = "SELECT SUM(amount) FROM expenses WHERE DATE_FORMAT(date, '%Y-%m') = ?";
        return (float) $this->db->getDbValue($sql, [$month]);
    }

    /**
     * Bir gideri belirli bir süre ertele.
     *
     * @param int $id Gider ID'si.
     * @param int|string $months Erteleme süresi (ay olarak) veya 'later'.
     * @return bool Başarı durumu.
     */
    public function postpone(int $id, $months): bool {
        $expense = $this->getById($id);
        if (!$expense) {
            return false;
        }

        $current_date = new DateTime($expense['date']);

        if ($months === 'later') {
            // Çok ileri bir tarihe ertele (örneğin 10 yıl)
            $current_date->modify('+10 year');
        } else {
            $current_date->modify('+' . (int)$months . ' month');
        }

        $new_date = $current_date->format('Y-m-d');

        // Giderin category_type'ını 'ertelenmis' olarak güncelle
        $sql = "UPDATE expenses SET date = ?, category_type = 'ertelenmis' WHERE id = ?";
        return $this->db->execute($sql, [$new_date, $id]);
    }
}