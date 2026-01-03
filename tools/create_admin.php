<?php
// tools/create_admin.php
// Usage (CLI): php create_admin.php username password

if (php_sapi_name() !== 'cli') {
    echo "Run this script from CLI: php create_admin.php username password\n";
    exit(1);
}
if ($argc < 3) {
    echo "Usage: php create_admin.php username password\n";
    exit(1);
}
$username = $argv[1];
$password = $argv[2];
if (trim($username) === '' || trim($password) === '') {
    echo "Username and password must not be empty\n";
    exit(1);
}
require_once __DIR__ . '/../config/db.php';
try {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        echo "User '$username' already exists.\n";
        exit(1);
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $ins = $pdo->prepare('INSERT INTO users (username, password_hash, created_at) VALUES (?, ?, NOW())');
    $ins->execute([$username, $hash]);
    echo "Admin user '$username' created successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>