<?php

namespace App\Controllers;

use App\Models\Expense;

class XtremeAiController {
    public function index() {
        $expense_model = new Expense();
        // Xtreme AI için özel bir kategori tipi olduğunu varsayıyoruz.
        // Eğer veritabanında 'xtreme_ai' diye bir category_type yoksa, bu kısım boş dönecektir.
        $rows = $expense_model->getAll('xtreme_ai');

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/xtreme_ai/index.php';
    }
}
