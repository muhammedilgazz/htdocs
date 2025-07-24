<?php

namespace App\Controllers;

use App\Services\ExpenseService;

class XtremeAiController {
    private $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index() {
        // Xtreme AI için özel bir kategori tipi olduğunu varsayıyoruz.
        // Eğer veritabanında 'xtreme_ai' diye bir category_type yoksa, bu kısım boş dönecektir.
        $rows = $this->expenseService->getAllExpensesByType('xtreme_ai');

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/xtreme_ai/index.php';
    }
}
