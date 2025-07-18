<?php
require_once __DIR__ . '/../bootstrap.php';

use App\Interfaces\ExpenseServiceInterface;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    /** @var ExpenseServiceInterface $expenseService */
    $expenseService = $container->get(ExpenseServiceInterface::class);
    
    $data = [
        'description' => sanitize_input($_POST['description']),
        'amount' => (float)$_POST['amount'],
        'category_type' => sanitize_input($_POST['category_type']),
        'date' => sanitize_input($_POST['date'])
    ];

    $result = $expenseService->createNewExpense($data);

    if ($result) {
        json_response(['success' => true, 'message' => 'Gider başarıyla eklendi.', 'expense_id' => $result]);
    } else {
        json_response(['success' => false, 'message' => 'Gider eklenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}