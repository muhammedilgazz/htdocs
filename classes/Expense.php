<?php

require_once __DIR__ . '/Database.php';

class Expense {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir harcama kalemi ekler.
     *
     * @param array $data Harcama verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO expense_items (order_number, category_id, item_name, amount, link, description, status_id) VALUES (?, (SELECT id FROM categories WHERE name = ? AND type = 'expense'), ?, ?, ?, ?, (SELECT id FROM status_types WHERE name = ?))";
        $params = [
            $data['sira'] ?? null,
            $data['kategori'] ?? null,
            $data['urun'] ?? null,
            $data['tutar'] ?? null,
            $data['link'] ?? null,
            $data['aciklama'] ?? null,
            $data['durum'] ?? 'Beklemede'
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir harcama kalemini ID'sine göre günceller.
     *
     * @param int $id Güncellenecek harcama kaleminin ID'si.
     * @param array $data Güncel harcama verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE expense_items SET order_number = ?, category_id = (SELECT id FROM categories WHERE name = ? AND type = 'expense'), item_name = ?, amount = ?, link = ?, description = ?, status_id = (SELECT id FROM status_types WHERE name = ?) WHERE id = ?";
        $params = [
            $data['sira'] ?? null,
            $data['kategori'] ?? null,
            $data['urun'] ?? null,
            $data['tutar'] ?? null,
            $data['link'] ?? null,
            $data['aciklama'] ?? null,
            $data['durum'] ?? 'Beklemede',
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir harcama kalemini ID'sine göre siler.
     *
     * @param int $id Silinecek harcama kaleminin ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM expense_items WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm harcama kalemlerini veya belirli bir kategori tipine göre harcama kalemlerini getirir.
     *
     * @param string|null $category_name Filtrelemek için kategori adı.
     * @return array Harcama kalemleri listesi.
     */
    public function getAll(?string $category_name = null): array {
        $sql = "SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id";
        $params = [];
        if ($category_name) {
            $sql .= " WHERE c.name = ? AND c.type = 'expense'";
            $params[] = $category_name;
        }
        $sql .= " ORDER BY ei.id DESC";
        return $this->db->fetchAll($sql, $params);
    }

    /**
     * Bir harcama kalemini ID'sine göre getirir.
     *
     * @param int $id Getirilecek harcama kaleminin ID'si.
     * @return array|false Harcama kalemi verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE ei.id = ?";
        return $this->db->fetch($sql, [$id]);
    }

    /**
     * Harcama kaleminin durumunu günceller.
     *
     * @param int $id Güncellenecek harcama kaleminin ID'si.
     * @param string $status Yeni durum.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function updateStatus(int $id, string $status): bool {
        $sql = "UPDATE expense_items SET status_id = (SELECT id FROM status_types WHERE name = ?) WHERE id = ?";
        return $this->db->execute($sql, [$status, $id]);
    }
}
