<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Personnel.php';

echo "🧪 Testing Personnel Creation...\n";

$pModel = new Personnel($pdo);

// Data mocking a form submission
$data = [
    'firstname' => 'Test',
    'lastname' => 'User',
    'email' => 'test.user@example.com',
    'phone' => '0123456789',
    'direction_id' => 1, // Assuming these exist from seeds
    'service_id' => 1,
    'poste_id' => 1,     // Assuming seeds created this
    'position' => 'Test Position',
    'status' => 'Actif',
    'hire_date' => date('Y-m-d'),
    'salary' => 50000.00,
    'notes' => 'Created via test script'
];

try {
    echo "Attempting to create personnel...\n";
    $newId = $pModel->create($data);
    
    if ($newId) {
        echo "✅ Success! Personnel created with ID: $newId\n";
    } else {
        echo "❌ Failed to create personnel.\n";
        if (file_exists(__DIR__ . '/../logs/db_error.log')) {
            echo "Log content:\n" . file_get_contents(__DIR__ . '/../logs/db_error.log');
        }
    }
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}
?>
