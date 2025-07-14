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

    public function getTotalExpenses() {
        return $this->db->getDbValue("SELECT SUM(amount) FROM expense_items");
    }

    public function getExpenseItemsCount() {
        return $this->db->getDbValue("SELECT COUNT(*) FROM expense_items WHERE category_id IS NOT NULL");
    }

    public function getTotalDebtPayments() {
        return $this->db->getDbValue("SELECT SUM(amount) FROM payments");
    }

    public function getRemainingDebtCount() {
        return $this->db->getDbValue("SELECT COUNT(*) FROM payments WHERE status_id != (SELECT id FROM status_types WHERE name = 'Ödendi')");
    }

    public function getTotalWishlistPrice() {
        return $this->db->getDbValue("SELECT SUM(price) FROM wishlist_items");
    }

    public function getApprovedWishlistCount() {
        return $this->db->getDbValue("SELECT COUNT(*) FROM wishlist_items WHERE will_get = TRUE");
    }

    public function getMonthlyFixedExpenses() {
        return $this->db->getDbValue("SELECT SUM(amount) FROM expense_items WHERE category_id = (SELECT id FROM categories WHERE name = 'abonelikler' AND type = 'expense')");
    }

    public function getOneTimeExpenses() {
        return $this->db->getDbValue("SELECT SUM(amount) FROM expense_items WHERE category_id != (SELECT id FROM categories WHERE name = 'abonelikler' AND type = 'expense')");
    }

    public function getFixedExpenses() {
        return $this->db->fetchAll("SELECT e.*, c.name as kategori_adi FROM expense_items e LEFT JOIN categories c ON e.category_id = c.id WHERE c.name='Sabit Giderler' ORDER BY e.id DESC");
    }

    public function getVariableExpenses() {
        return $this->db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE c.name = 'Değişken Giderler' AND c.type = 'expense' ORDER BY ei.id DESC");
    }

    public function getDebtPayments() {
        return $this->db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE c.name = 'Borç Ödemeleri' AND c.type = 'expense' ORDER BY ei.id DESC");
    }

    public function getExtraExpenses() {
        return $this->db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE c.name = 'Ani/Ekstra Harcama' AND c.type = 'expense' ORDER BY ei.id DESC");
    }

    public function getPostponedPayments() {
        return $this->db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE st.name = 'Ertelendi' ORDER BY ei.created_at ASC");
    }

    public function getTaxExpenses() {
        return $this->db->fetchAll("SELECT e.*, c.name as kategori_adi FROM expense_items e LEFT JOIN categories c ON e.category_id = c.id WHERE c.name LIKE '%Vergi%' ORDER BY e.id DESC");
    }

    public function getSgkExpenses($selected_month) {
        return $this->db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE c.name LIKE '%SGK%' AND ei.created_at LIKE ? ORDER BY ei.id DESC", ['%' . $selected_month . '%']);
    }

    public function getBankExpenses() {
        return $this->db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE c.name LIKE '%banka%' AND c.type = 'expense' ORDER BY ei.id DESC");
    }

    public function getExecutionExpenses($selected_month) {
        return $this->db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE c.name LIKE '%icra%' AND ei.created_at LIKE ? ORDER BY ei.id DESC", ['%' . $selected_month . '%']);
    }

    public function getNeeds() {
        return $this->db->fetchAll("SELECT e.*, c.name as kategori_adi FROM expense_items e LEFT JOIN categories c ON e.category_id = c.id WHERE c.name = 'İhtiyaç' ORDER BY e.id DESC");
    }

    public function getProjects($selected_month) {
        return $this->db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE c.name LIKE '%proje%' AND ei.created_at LIKE ? ORDER BY ei.id DESC", ['%' . $selected_month . '%']);
    }

    public function getTasks($selected_month) {
        return $this->db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE c.name LIKE '%görev%' AND ei.created_at LIKE ? ORDER BY ei.id DESC", ['%' . $selected_month . '%']);
    }

    public function getTodoList($selected_month) {
        return $this->db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE c.name LIKE '%todo%' AND ei.created_at LIKE ? ORDER BY ei.id DESC", ['%' . $selected_month . '%']);
    }
}

    public function getIndividualDebts($selected_month) {
        return $this->db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE c.name LIKE '%şahıs%' AND ei.created_at LIKE ? ORDER BY ei.id DESC", ['%' . $selected_month . '%']);
    }

    public function getXtremeAiExpenses() {
        $sql = "SELECT e.*, c.name as category_name, c.type as category_type, s.name as status_name 
                FROM expense_items e 
                LEFT JOIN categories c ON e.category_id = c.id 
                LEFT JOIN status_types s ON e.status_id = s.id 
                WHERE c.name LIKE '%ai%' OR c.type LIKE '%ai%' 
                ORDER BY e.id DESC";
        return $this->db->fetchAll($sql);
    }
}
