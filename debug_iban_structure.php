<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/Iban.php';

$db = Database::getInstance();
$iban_model = new Iban();

echo "<h2>IBAN Table Structure Debug</h2>";

// Check table structure
$sql = "DESCRIBE iban_details";
$structure = $db->fetchAll($sql);

echo "<h3>Table Structure:</h3>";
echo "<pre>";
print_r($structure);
echo "</pre>";

// Check if there's any data
$sql = "SELECT * FROM iban_details LIMIT 5";
$data = $db->fetchAll($sql);

echo "<h3>Sample Data:</h3>";
echo "<pre>";
print_r($data);
echo "</pre>";

// Test the fixed Iban class
$all_ibans = $iban_model->getAll();
echo "<h3>Fixed Iban Class Result:</h3>";
echo "<pre>";
print_r($all_ibans);
echo "</pre>";

// Test the separation logic
$my_ibans = [];
$other_ibans = [];

foreach ($all_ibans as $iban) {
    if ($iban['account_type'] === 'own') {
        $my_ibans[] = $iban;
    } else {
        $other_ibans[] = $iban;
    }
}

echo "<h3>My IBANs (account_type = 'own'):</h3>";
echo "<pre>";
print_r($my_ibans);
echo "</pre>";

echo "<h3>Other IBANs (account_type = 'other'):</h3>";
echo "<pre>";
print_r($other_ibans);
echo "</pre>";
?> 