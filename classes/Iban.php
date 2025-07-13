<?php

require_once __DIR__ . '/Database.php';

class Iban {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir IBAN kaydı ekler.
     *
     * @param array $data IBAN verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO iban_bilgileri (banka_adi, iban, hesap_sahibi, aciklama, hesap_turu) VALUES (?, ?, ?, ?, ?)";
        $params = [
            $data['banka_adi'] ?? null,
            $data['iban'] ?? null,
            $data['hesap_sahibi'] ?? null,
            $data['aciklama'] ?? null,
            $data['hesap_turu'] ?? 'diger' // Varsayılan olarak 'diger'
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir IBAN kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek IBAN kaydının ID'si.
     * @param array $data Güncel IBAN verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE iban_bilgileri SET banka_adi = ?, iban = ?, hesap_sahibi = ?, aciklama = ?, hesap_turu = ? WHERE id = ?";
        $params = [
            $data['banka_adi'] ?? null,
            $data['iban'] ?? null,
            $data['hesap_sahibi'] ?? null,
            $data['aciklama'] ?? null,
            $data['hesap_turu'] ?? 'diger',
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir IBAN kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek IBAN kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM iban_bilgileri WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm IBAN kayıtlarını veya belirli bir hesap türüne göre IBAN kayıtlarını getirir.
     *
     * @param string|null $hesap_turu Filtrelemek için hesap türü ('kendi' veya 'diger').
     * @return array IBAN kayıtları listesi.
     */
    public function getAll(?string $hesap_turu = null): array {
        $sql = "SELECT * FROM iban_bilgileri";
        $params = [];
        if ($hesap_turu) {
            $sql .= " WHERE hesap_turu = ?";
            $params[] = $hesap_turu;
        }
        $sql .= " ORDER BY id DESC";
        return $this->db->fetchAll($sql, $params);
    }

    /**
     * Bir IBAN kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek IBAN kaydının ID'si.
     * @return array|false IBAN kaydı verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM iban_bilgileri WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}