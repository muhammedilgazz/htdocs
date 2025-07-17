<?php

namespace App\Interfaces;

interface ExpenseServiceInterface {
    public function listAllExpenses(?string $category_type = null): array;
    public function createNewExpense(array $data);
    public function getExpenseById(int $id);
    public function updateExistingExpense(int $id, array $data): bool;
    public function deleteExpenseById(int $id): bool;
    public function postponeExpense(int $id, $months): bool;
}