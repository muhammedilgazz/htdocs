<?php
require_once 'config/config.php';
require_once 'classes/Database.php';

$db = Database::getInstance();

echo "<h2>Users Table Debug</h2>";

// Check table structure
$sql = "DESCRIBE users";
$structure = $db->fetchAll($sql);

echo "<h3>Users Table Structure:</h3>";
echo "<pre>";
print_r($structure);
echo "</pre>";

// Check if there's any data
$sql = "SELECT * FROM users LIMIT 5";
$data = $db->fetchAll($sql);

echo "<h3>Sample Users Data:</h3>";
echo "<pre>";
print_r($data);
echo "</pre>";
?> 