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
        $sql = "INSERT INTO hayaller_hedefler (baslik, aciklama, hedef_tutar, mevcut_tutar, durum, hedef_tarih) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $data['baslik'] ?? null,
            $data['aciklama'] ?? null,
            $data['hedef_tutar'] ?? null,
            $data['mevcut_tutar'] ?? 0,
            $data['durum'] ?? 'Beklemede',
            $data['hedef_tarih'] ?? null
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
        $sql = "UPDATE hayaller_hedefler SET baslik = ?, aciklama = ?, hedef_tutar = ?, mevcut_tutar = ?, durum = ?, hedef_tarih = ? WHERE id = ?";
        $params = [
            $data['baslik'] ?? null,
            $data['aciklama'] ?? null,
            $data['hedef_tutar'] ?? null,
            $data['mevcut_tutar'] ?? null,
            $data['durum'] ?? null,
            $data['hedef_tarih'] ?? null,
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
        $sql = "DELETE FROM hayaller_hedefler WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm hayal/hedef kayıtlarını getirir.
     *
     * @return array Hayal/hedef kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM hayaller_hedefler ORDER BY id DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir hayal/hedef kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek hayal/hedef kaydının ID'si.
     * @return array|false Hayal/hedef verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM hayaller_hedefler WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}
