<?php
require_once __DIR__ . '/../bootstrap.php';

use App\Interfaces\ExpenseServiceInterface;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    /** @var ExpenseServiceInterface $expenseService */
    $expenseService = $container->get(ExpenseServiceInterface::class);
    $id = (int)$_POST['id'];

    $expense = $expenseService->getExpenseById($id);

    if ($expense) {
        json_response(['success' => true, 'data' => $expense]);
    } else {
        json_response(['success' => false, 'message' => 'Gider bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}