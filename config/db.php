<?php
// config/db.php
// Changez les paramètres selon votre environnement XAMPP
$db_host = '127.0.0.1';
$db_name = 'gestion_personnel';
$db_user = 'root';
$db_pass = '';
$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    die('DB Error: ' . $e->getMessage());
}
?>