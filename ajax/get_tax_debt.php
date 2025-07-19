<?php
require_once '../bootstrap.php';

use App\Models\TaxDebt;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tax_debt_model = new TaxDebt();
    $id = (int)$_POST['id'];

    $debt = $tax_debt_model->getById($id);

    if ($debt) {
        json_response(['success' => true, 'data' => $debt]);
    } else {
        json_response(['success' => false, 'message' => 'Vergi borcu bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
