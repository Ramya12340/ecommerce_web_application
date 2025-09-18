<?php
// Database connection
$host = '127.0.0.1';
$db = 'ecommerce_db';
$user = 'root';
$pass = '1234';  // Replace with your actual MySQL password
$charset = 'utf8mb4';

// DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Enable exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Fetch data as an associative array
    PDO::ATTR_EMULATE_PREPARES => false,  // Disable emulation for prepared statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);  // Create PDO instance
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();  // Handle connection failure
}
?>
