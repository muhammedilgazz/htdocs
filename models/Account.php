<?php

require_once __DIR__ . '/Database.php';

class Account {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir hesap/şifre kaydı ekler.
     *
     * @param array $data Hesap verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO account_credentials (platform, username, password, login_link, account_type_id) VALUES (?, ?, ?, ?, (SELECT id FROM account_types WHERE name = ?))";
        $params = [
            $data['platform'] ?? null,
            $data['username'] ?? null,
            $data['password'] ?? null,
            $data['login_link'] ?? null,
            $data['account_type'] ?? null
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir hesap/şifre kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek hesabın ID'si.
     * @param array $data Güncel hesap verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE account_credentials SET platform = ?, username = ?, password = ?, login_link = ?, account_type_id = (SELECT id FROM account_types WHERE name = ?) WHERE id = ?";
        $params = [
            $data['platform'] ?? null,
            $data['username'] ?? null,
            $data['password'] ?? null,
            $data['login_link'] ?? null,
            $data['account_type'] ?? null,
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir hesap/şifre kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek hesabın ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM account_credentials WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm hesap/şifre kayıtlarını getirir.
     *
     * @return array Hesap kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT ac.*, at.name as account_type_name FROM account_credentials ac JOIN account_types at ON ac.account_type_id = at.id ORDER BY ac.created_at DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir hesap/şifre kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek hesabın ID'si.
     * @return array|false Hesap verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT ac.*, at.name as account_type_name FROM account_credentials ac JOIN account_types at ON ac.account_type_id = at.id WHERE ac.id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}
