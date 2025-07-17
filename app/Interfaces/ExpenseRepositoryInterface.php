<?php

namespace App\Interfaces;

interface ExpenseRepositoryInterface {
    /**
     * Yeni bir gider ekler.
     *
     * @param array $data Gider verileri.
     * @return int|false Eklenen giderin ID'si veya hata durumunda false.
     */
    public function create(array $data);

    /**
     * Bir gideri ID'sine göre günceller.
     *
     * @param int $id Güncellenecek giderin ID'si.
     * @param array $data Yeni gider verileri.
     * @return bool Başarı durumu.
     */
    public function update(int $id, array $data): bool;

    /**
     * Bir gideri ID'sine göre siler.
     *
     * @param int $id Silinecek giderin ID'si.
     * @return bool Başarı durumu.
     */
    public function delete(int $id): bool;

    /**
     * Bir gideri ID'sine göre bulur.
     *
     * @param int $id Gider ID'si.
     * @return array|false Gider verileri veya bulunamazsa false.
     */
    public function findById(int $id);

    /**
     * Tüm giderleri veya belirli bir kategoriye göre giderleri getirir.
     *
     * @param string|null $category_type Filtrelemek için kategori tipi.
     * @return array Giderler listesi.
     */
    public function findAll(?string $category_type = null): array;

    /**
     * Belirtilen ayın toplam giderini hesaplar.
     *
     * @param string $month 'Y-m' formatında ay.
     * @return float Toplam gider.
     */
    public function getMonthlyTotal(string $month): float;
}