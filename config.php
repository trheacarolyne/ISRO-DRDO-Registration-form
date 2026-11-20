<?php
// Update these values only if your local XAMPP MySQL settings are different.
$DB_HOST = 'localhost';
$DB_NAME = 'isro_drdo_portal';
$DB_USER = 'root';
$DB_PASS = '';

try {
    $pdo = new PDO(
        "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
         PDO::ATTR_EMULATE_PREPARES => false]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit("Database connection failed. Check that MySQL is running and that the database 'isro_drdo_portal' exists. Details: " . htmlspecialchars($e->getMessage()));
}
