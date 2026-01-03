<?php
/**
 * API endpoint pour récupérer les postes d'un service via AJAX
 * Utilisé pour les cascades de filtres dans le formulaire personnel
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Poste.php';

session_start();

// Vérifier l'authentification
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$service_id = $_GET['service_id'] ?? null;

if (!$service_id) {
    http_response_code(400);
    echo json_encode(['error' => 'service_id is required']);
    exit;
}

try {
    $posteModel = new Poste($pdo);
    
    // Check if postes table exists
    try {
        $stmt = $pdo->query("SHOW TABLES LIKE 'postes'");
        $tableExists = $stmt->rowCount() > 0;
    } catch (Exception $e) {
        $tableExists = false;
    }
    
    if (!$tableExists) {
        echo json_encode([
            'success' => true,
            'postes' => [],
            'message' => 'Postes table does not exist yet'
        ]);
        exit;
    }
    
    $postes = $posteModel->byService($service_id);
    
    echo json_encode([
        'success' => true,
        'postes' => $postes
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
