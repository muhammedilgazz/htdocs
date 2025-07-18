<?php
require_once __DIR__ . '/../bootstrap.php';

use App\Interfaces\ExpenseServiceInterface;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    /** @var ExpenseServiceInterface $expenseService */
    $expenseService = $container->get(ExpenseServiceInterface::class);
    
    $id = (int)$_POST['id'];
    $data = [
        'description' => sanitize_input($_POST['description']),
        'amount' => (float)$_POST['amount'],
        'category_type' => sanitize_input($_POST['category_type']),
        'date' => sanitize_input($_POST['date'])
    ];

    if ($expenseService->updateExistingExpense($id, $data)) {
        json_response(['success' => true, 'message' => 'Gider başarıyla güncellendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Gider güncellenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}