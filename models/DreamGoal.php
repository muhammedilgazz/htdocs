<?php

require_once __DIR__ . '/Database.php';

class DreamGoal {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir hayal/hedef kaydı ekler.
     *
     * @param array $data Hayal/hedef verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO dream_goals (goal_name, description, target_amount, target_date) VALUES (?, ?, ?, ?)";
        $params = [
            $data['goal_name'] ?? null,
            $data['description'] ?? null,
            $data['target_amount'] ?? null,
            $data['target_date'] ?? null
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir hayal/hedef kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek hayal/hedef kaydının ID'si.
     * @param array $data Güncel hayal/hedef verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE dream_goals SET goal_name = ?, description = ?, target_amount = ?, target_date = ? WHERE id = ?";
        $params = [
            $data['goal_name'] ?? null,
            $data['description'] ?? null,
            $data['target_amount'] ?? null,
            $data['target_date'] ?? null,
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir hayal/hedef kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek hayal/hedef kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM dream_goals WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm hayal/hedef kayıtlarını getirir.
     *
     * @return array Hayal/hedef kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM dream_goals ORDER BY id DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir hayal/hedef kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek hayal/hedef kaydının ID'si.
     * @return array|false Hayal/hedef verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM dream_goals WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}
