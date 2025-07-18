<?php
require_once __DIR__ . '/../bootstrap.php';

use App\Interfaces\ExpenseServiceInterface;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    /** @var ExpenseServiceInterface $expenseService */
    $expenseService = $container->get(ExpenseServiceInterface::class);
    $id = (int)$_POST['id'];

    if ($expenseService->deleteExpenseById($id)) {
        json_response(['success' => true, 'message' => 'Gider başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'Gider silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}