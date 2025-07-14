<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'includes/month_helper.php';

$db = Database::getInstance();

echo "<h2>Xtreme AI Test</h2>";

// Test the query
$sql = "SELECT e.*, c.name as category_name, c.type as category_type, s.name as status_name 
        FROM expense_items e 
        LEFT JOIN categories c ON e.category_id = c.id 
        LEFT JOIN status_types s ON e.status_id = s.id 
        WHERE c.name LIKE '%ai%' OR c.type LIKE '%ai%' 
        ORDER BY e.id DESC";

try {
    $result = $db->fetchAll($sql);
    echo "<h3>Query Result:</h3>";
    echo "<pre>";
    print_r($result);
    echo "</pre>";
    
    echo "<h3>Row Count: " . count($result) . "</h3>";
    
    if (empty($result)) {
        echo "<p>No AI items found. This is expected since there are no AI categories in the database yet.</p>";
        
        // Show available categories
        $categories = $db->fetchAll("SELECT * FROM categories ORDER BY name");
        echo "<h3>Available Categories:</h3>";
        echo "<pre>";
        print_r($categories);
        echo "</pre>";
    }
    
} catch (Exception $e) {
    echo "<h3>Query Error:</h3>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

// Test month helper
$selected_month = getSelectedMonthKey();
echo "<h3>Selected Month: " . $selected_month . "</h3>";

// Test month options generation
echo "<h3>Month Options:</h3>";
echo generateMonthOptions($selected_month);
?> 