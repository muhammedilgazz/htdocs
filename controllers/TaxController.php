<?php

namespace App\Controllers;

use App\Models\TaxDebt;

class TaxController {
    public function index() {
        $tax_debt_model = new TaxDebt();
        $rows = $tax_debt_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/tax/index.php';
    }
}