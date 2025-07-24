<?php

namespace App\Models;

use App\Repositories\DashboardRepository;

class Dashboard
{
    private $dashboard_repository;

    public function __construct(DashboardRepository $dashboard_repository)
    {
        $this->dashboard_repository = $dashboard_repository;
    }

    /**
     * Ana sayfa için temel istatistikleri toplar.
     */
    public function getDashboardStats()
    {
        return $this->dashboard_repository->getDashboardStats();
    }

    /**
     * Son işlemleri (giderler ve alınacaklar) getirir.
     */
    public function getRecentTransactions()
    {
        return $this->dashboard_repository->getRecentTransactions();
    }

    /**
     * Giderleri kategoriye göre gruplandırarak getirir.
     */
    public function getCategoryExpenses()
    {
        return $this->dashboard_repository->getCategoryExpenses();
    }
}
