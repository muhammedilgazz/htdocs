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
        $sql = "INSERT INTO hesaplar_sifreler (platform, kullanici_adi, sifre, giris_linki, hesap_turu) VALUES (?, ?, ?, ?, ?)";
        $params = [
            $data['platform'] ?? null,
            $data['kullanici_adi'] ?? null,
            $data['sifre'] ?? null,
            $data['giris_linki'] ?? null,
            $data['hesap_turu'] ?? null
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
        $sql = "UPDATE hesaplar_sifreler SET platform = ?, kullanici_adi = ?, sifre = ?, giris_linki = ?, hesap_turu = ? WHERE id = ?";
        $params = [
            $data['platform'] ?? null,
            $data['kullanici_adi'] ?? null,
            $data['sifre'] ?? null,
            $data['giris_linki'] ?? null,
            $data['hesap_turu'] ?? null,
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
        $sql = "DELETE FROM hesaplar_sifreler WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm hesap/şifre kayıtlarını getirir.
     *
     * @return array Hesap kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM hesaplar_sifreler ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir hesap/şifre kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek hesabın ID'si.
     * @return array|false Hesap verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM hesaplar_sifreler WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}
