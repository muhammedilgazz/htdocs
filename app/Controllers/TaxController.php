<?php

namespace App\Controllers;

use App\Models\TaxDebt;

class TaxController {
    public function index() {
        $tax_debt_model = new TaxDebt();
        $rows = $tax_debt_model->getAll();
        
        $summary = [
            'personal' => $tax_debt_model->getTaxDebtAmountByOwner('Şahsi'),
            'timdesigners' => $tax_debt_model->getTaxDebtAmountByOwner('Timdesigners'),
            'rentakar' => $tax_debt_model->getTaxDebtAmountByOwner('RentAkar'),
            'total' => $tax_debt_model->getTotalTaxDebtAmount()
        ];

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/tax/index.php';
    }
}