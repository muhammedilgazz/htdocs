<?php

namespace App\Models;

use App\Models\Database;

class AccountCredential {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir hesap bilgisi kaydı ekler.
     *
     * @param array $data Hesap bilgisi verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO account_credentials (user_id, platform_name, username, login_url, account_type_id, password_hash) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $data['user_id'] ?? 1, // Varsayılan kullanıcı ID'si
            $data['platform_name'] ?? null,
            $data['username'] ?? null,
            $data['login_url'] ?? null,
            $data['account_type_id'] ?? 6, // Varsayılan hesap tipi ID'si
            $data['password_hash'] ?? null
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir hesap bilgisi kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek hesap bilgisi kaydının ID'si.
     * @param array $data Güncel hesap bilgisi verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        // Mevcut şifreyi korumak için önce mevcut kaydı al
        $current = $this->getById($id);
        $sql = "UPDATE account_credentials SET platform_name = ?, username = ?, login_url = ?, account_type_id = ?, password_hash = ? WHERE id = ?";
        $params = [
            $data['platform_name'] ?? null,
            $data['username'] ?? null,
            $data['login_url'] ?? null,
            $data['account_type_id'] ?? 6,
            (isset($data['password_hash']) && !empty($data['password_hash'])) ? $data['password_hash'] : ($current['password_hash'] ?? null),
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir hesap bilgisi kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek hesap bilgisi kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM account_credentials WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm hesap bilgisi kayıtlarını getirir.
     *
     * @return array Hesap bilgisi kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT ac.*, at.name as account_type_name FROM account_credentials ac LEFT JOIN account_types at ON ac.account_type_id = at.id ORDER BY ac.created_at DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir hesap bilgisi kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek hesap bilgisi kaydının ID'si.
     * @return array|false Hesap bilgisi kaydı verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT ac.*, at.name as account_type_name FROM account_credentials ac LEFT JOIN account_types at ON ac.account_type_id = at.id WHERE ac.id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}