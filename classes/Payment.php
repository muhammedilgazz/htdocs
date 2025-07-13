<?php

require_once __DIR__ . '/Database.php';

class Payment {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir ödeme kaydı ekler.
     *
     * @param array $data Ödeme verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO payments (person_name, iban, amount, status_id) VALUES (?, ?, ?, (SELECT id FROM status_types WHERE name = ?))";
        $params = [
            $data['person_name'] ?? null,
            $data['iban'] ?? null,
            $data['amount'] ?? null,
            $data['status'] ?? 'Beklemede'
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir ödeme kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek ödeme kaydının ID'si.
     * @param array $data Güncel ödeme verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE payments SET person_name = ?, iban = ?, amount = ?, status_id = (SELECT id FROM status_types WHERE name = ?) WHERE id = ?";
        $params = [
            $data['person_name'] ?? null,
            $data['iban'] ?? null,
            $data['amount'] ?? null,
            $data['status'] ?? 'Beklemede',
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir ödeme kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek ödeme kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM payments WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm ödeme kayıtlarını getirir.
     *
     * @return array Ödeme kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT p.*, st.name as status_name FROM payments p JOIN status_types st ON p.status_id = st.id ORDER BY p.created_at DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir ödeme kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek ödeme kaydının ID'si.
     * @return array|false Ödeme kaydı verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT p.*, st.name as status_name FROM payments p JOIN status_types st ON p.status_id = st.id WHERE p.id = ?";
        return $this->db->fetch($sql, [$id]);
    }

    /**
     * Ödeme durumunu günceller.
     *
     * @param int $id Güncellenecek ödeme kaydının ID'si.
     * @param string $status Yeni durum.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function updateStatus(int $id, string $status): bool {
        $sql = "UPDATE payments SET status_id = (SELECT id FROM status_types WHERE name = ?) WHERE id = ?";
        return $this->db->execute($sql, [$status, $id]);
    }
}
