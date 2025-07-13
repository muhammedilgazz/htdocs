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
        $sql = "INSERT INTO harcama_kalemleri (kategori, kategori_tipi, harcama_donemi, tur, sira, urun, tutar, link, aciklama, durum) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $data['kategori'] ?? null,
            $data['kategori_tipi'] ?? null,
            $data['harcama_donemi'] ?? null,
            $data['tur'] ?? null,
            $data['sira'] ?? null,
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
        $sql = "UPDATE harcama_kalemleri SET kategori = ?, kategori_tipi = ?, harcama_donemi = ?, tur = ?, sira = ?, urun = ?, tutar = ?, link = ?, aciklama = ?, durum = ? WHERE id = ?";
        $params = [
            $data['kategori'] ?? null,
            $data['kategori_tipi'] ?? null,
            $data['harcama_donemi'] ?? null,
            $data['tur'] ?? null,
            $data['sira'] ?? null,
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
        $sql = "DELETE FROM harcama_kalemleri WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm harcama kalemlerini veya belirli bir kategori tipine göre harcama kalemlerini getirir.
     *
     * @param string|null $kategori_tipi Filtrelemek için kategori tipi.
     * @return array Harcama kalemleri listesi.
     */
    public function getAll(?string $kategori_tipi = null): array {
        $sql = "SELECT * FROM harcama_kalemleri";
        $params = [];
        if ($kategori_tipi) {
            $sql .= " WHERE kategori_tipi = ?";
            $params[] = $kategori_tipi;
        }
        $sql .= " ORDER BY id DESC";
        return $this->db->fetchAll($sql, $params);
    }

    /**
     * Bir harcama kalemini ID'sine göre getirir.
     *
     * @param int $id Getirilecek harcama kaleminin ID'si.
     * @return array|false Harcama kalemi verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM harcama_kalemleri WHERE id = ?";
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
        $sql = "UPDATE harcama_kalemleri SET durum = ? WHERE id = ?";
        return $this->db->execute($sql, [$status, $id]);
    }
}
