<?php

namespace App\Models;

/**
 * Expense Data Transfer Object (DTO)
 *
 * Bu sınıf, bir gider kaydının veri yapısını temsil eder.
 * Herhangi bir veritabanı veya iş mantığı içermez.
 */
class Expense
{
    public int $id;
    public float $amount;
    public string $category_type;
    public ?string $description;
    public string $date;
}