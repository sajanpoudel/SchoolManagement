<?php

// Same settings as config/Database.php: DB_HOST, DB_USER, DB_PASSWORD and DB_NAME override the XAMPP defaults.
$DB_host = getenv('DB_HOST') ?: "localhost";
$DB_user = getenv('DB_USER') ?: "root";
$DB_pass = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : "";
$DB_name = getenv('DB_NAME') ?: "schoolmanagement";
try {
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
}
