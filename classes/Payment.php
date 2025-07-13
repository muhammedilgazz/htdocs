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
        $sql = "INSERT INTO odemeler (kisi_adi, iban, tutar, durum) VALUES (?, ?, ?, ?)";
        $params = [
            $data['kisi_adi'] ?? null,
            $data['iban'] ?? null,
            $data['tutar'] ?? null,
            $data['durum'] ?? 'Beklemede'
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
        $sql = "UPDATE odemeler SET kisi_adi = ?, iban = ?, tutar = ?, durum = ? WHERE id = ?";
        $params = [
            $data['kisi_adi'] ?? null,
            $data['iban'] ?? null,
            $data['tutar'] ?? null,
            $data['durum'] ?? 'Beklemede',
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
        $sql = "DELETE FROM odemeler WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm ödeme kayıtlarını getirir.
     *
     * @return array Ödeme kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM odemeler ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir ödeme kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek ödeme kaydının ID'si.
     * @return array|false Ödeme kaydı verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM odemeler WHERE id = ?";
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
        $sql = "UPDATE odemeler SET durum = ? WHERE id = ?";
        return $this->db->execute($sql, [$status, $id]);
    }
}
