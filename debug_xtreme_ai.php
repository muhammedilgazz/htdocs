<?php
require_once 'config/config.php';
require_once 'models/Database.php';
require_once 'models/UIHelper.php';

$db = Database::getInstance();

echo "<h2>Xtreme AI Debug</h2>";

// Check table structure
$sql = "DESCRIBE expense_items";
$structure = $db->fetchAll($sql);

echo "<h3>Expense Items Table Structure:</h3>";
echo "<pre>";
print_r($structure);
echo "</pre>";

// Check if there's any data
$sql = "SELECT * FROM expense_items LIMIT 5";
$data = $db->fetchAll($sql);

echo "<h3>Sample Data:</h3>";
echo "<pre>";
print_r($data);
echo "</pre>";

// Check categories table
$sql = "SELECT * FROM categories WHERE name LIKE '%ai%' OR type LIKE '%ai%'";
$categories = $db->fetchAll($sql);

echo "<h3>AI Categories:</h3>";
echo "<pre>";
print_r($categories);
echo "</pre>";

// Test the current query logic
$selected_month = UIHelper::getSelectedMonthKey();
echo "<h3>Selected Month: " . $selected_month . "</h3>";

// Try to find AI-related items
$sql = "SELECT e.*, c.name as category_name, c.type as category_type 
        FROM expense_items e 
        LEFT JOIN categories c ON e.category_id = c.id 
        WHERE c.name LIKE '%ai%' OR c.type LIKE '%ai%' 
        ORDER BY e.id DESC";
try {
    $result = $db->fetchAll($sql);
    echo "<h3>AI Items Query Result:</h3>";
    echo "<pre>";
    print_r($result);
    echo "</pre>";
} catch (Exception $e) {
    echo "<h3>Query Error:</h3>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?> 