<?php

require_once __DIR__ . '/Database.php';

class Note {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir not ekler.
     *
     * @param array $data Not verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO notlar (baslik, icerik) VALUES (?, ?)";
        $params = [
            $data['baslik'] ?? null,
            $data['icerik'] ?? null
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir notu ID'sine göre günceller.
     *
     * @param int $id Güncellenecek notun ID'si.
     * @param array $data Güncel not verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE notlar SET baslik = ?, icerik = ? WHERE id = ?";
        $params = [
            $data['baslik'] ?? null,
            $data['icerik'] ?? null,
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir notu ID'sine göre siler.
     *
     * @param int $id Silinecek notun ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM notlar WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm notları getirir.
     *
     * @return array Notlar listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM notlar ORDER BY id DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir notu ID'sine göre getirir.
     *
     * @param int $id Getirilecek notun ID'si.
     * @return array|false Not verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM notlar WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}
