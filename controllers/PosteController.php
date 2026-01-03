<?php
/**
 * Contrôleur Poste - Gestion complète des postes
 * Intègre la hiérarchie: Direction → Service → Poste → Personnel
 */

// Vérifier si la table postes existe
$checkPostes = false;
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'postes'");
    $checkPostes = $stmt->rowCount() > 0;
} catch (Exception $e) {
    $checkPostes = false;
}

if (!$checkPostes) {
    require __DIR__ . '/../views/layout/header.php';
    echo '<div class="max-w-2xl mx-auto mt-8"><div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6"><h1 class="text-xl font-bold text-yellow-900 dark:text-yellow-100 mb-2">⚠️ Migration requise</h1><p class="text-yellow-800 dark:text-yellow-200 mb-4">La table des postes n\'existe pas encore. Veuillez exécuter la migration:</p><a href="migrate_postes.php" class="inline-block px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg font-medium">Exécuter migrate_postes.php →</a></div></div>';
    require __DIR__ . '/../views/layout/footer.php';
    exit;
}

require_once __DIR__ . '/../models/Poste.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Direction.php';
require_once __DIR__ . '/../models/Personnel.php';

$posteModel = new Poste($pdo);
$serviceModel = new Service($pdo);
$directionModel = new Direction($pdo);

switch ($action) {
    case 'list':
        // Récupérer les filtres
        $filters = [
            'direction_id' => $_GET['direction_id'] ?? null,
            'service_id' => $_GET['service_id'] ?? null,
        ];
        
        $postes = $posteModel->all($filters);
        $directions = $directionModel->all();
        $services = $serviceModel->all();
        
        require __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/postes/list.php';
        require __DIR__ . '/../views/layout/footer.php';
        break;
    
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'name' => $_POST['name'] ?? '',
                    'description' => $_POST['description'] ?? '',
                    'service_id' => $_POST['service_id'] ?? null,
                ];
                
                // Validation
                if (empty($data['name']) || empty($data['service_id'])) {
                    $error = "Le nom et le service sont obligatoires";
                } else {
                    $posteModel->create($data);
                    header('Location: index.php?page=poste&action=list');
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        $directions = $directionModel->all();
        $services = $serviceModel->all();
        
        require __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/postes/form.php';
        require __DIR__ . '/../views/layout/footer.php';
        break;
    
    case 'edit':
        $poste_id = $_GET['id'] ?? null;
        if (!$poste_id) {
            header('Location: index.php?page=poste&action=list');
            exit;
        }
        
        $poste = $posteModel->find($poste_id);
        if (!$poste) {
            header('Location: index.php?page=poste&action=list');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'name' => $_POST['name'] ?? '',
                    'description' => $_POST['description'] ?? '',
                    'service_id' => $_POST['service_id'] ?? null,
                ];
                
                if (empty($data['name']) || empty($data['service_id'])) {
                    $error = "Le nom et le service sont obligatoires";
                } else {
                    $posteModel->update($poste_id, $data);
                    header('Location: index.php?page=poste&action=view&id=' . $poste_id);
                    exit;
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        $directions = $directionModel->all();
        $services = $serviceModel->all();
        $edit_mode = true;
        
        require __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/postes/form.php';
        require __DIR__ . '/../views/layout/footer.php';
        break;
    
    case 'view':
        $poste_id = $_GET['id'] ?? null;
        if (!$poste_id) {
            header('Location: index.php?page=poste&action=list');
            exit;
        }
        
        $poste = $posteModel->find($poste_id);
        if (!$poste) {
            header('Location: index.php?page=poste&action=list');
            exit;
        }
        
        $stats = $posteModel->getStats($poste_id);
        $personnel = $posteModel->getPersonnel($poste_id);
        $service = $serviceModel->find($poste['service_id']);
        
        require __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/postes/view.php';
        require __DIR__ . '/../views/layout/footer.php';
        break;
    
    case 'delete':
        $poste_id = $_GET['id'] ?? null;
        if ($poste_id) {
            $posteModel->delete($poste_id);
        }
        header('Location: index.php?page=poste&action=list');
        exit;
    
    default:
        header('Location: index.php?page=poste&action=list');
        exit;
}
?>
