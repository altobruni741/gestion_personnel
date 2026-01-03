<?php
require_once __DIR__ . '/../models/Personnel.php';
require_once __DIR__ . '/../models/Direction.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Poste.php';

// Vérifier si la migration est nécessaire
if (!file_exists(__DIR__ . '/../.migration_done')) {
    header('Location: setup.php');
    exit;
}

$pModel = new Personnel($pdo);
$dirModel = new Direction($pdo);
$svcModel = new Service($pdo);
$posteModel = new Poste($pdo);

// Vérifier si les colonnes de contrat existent (pour l'opt-in migration)
$needsContractMigration = !($pModel->columnExists('personnel','contract_duration') && $pModel->columnExists('personnel','contract_end'));

if ($action === 'list') {
    // Récupérer les filtres
    $filters = [];
    if (!empty($_GET['status'])) $filters['status'] = $_GET['status'];
    if (!empty($_GET['direction_id'])) $filters['direction_id'] = $_GET['direction_id'];
    if (!empty($_GET['service_id'])) $filters['service_id'] = $_GET['service_id'];
    if (!empty($_GET['search'])) $filters['search'] = $_GET['search'];
    
    $personnel = $pModel->all($filters);
    // détecter les contrats arrivant à expiration dans <= 10 jours
    $expiring = [];
    foreach ($personnel as $pp) {
        if (!empty($pp['contract_end'])) {
            $days = (int) ceil((strtotime($pp['contract_end']) - time()) / 86400);
            if ($days >= 0 && $days <= 10) {
                $expiring[] = ['id' => $pp['id'], 'days' => $days, 'firstname' => $pp['firstname'], 'lastname' => $pp['lastname']];
            }
        }
    }
    $directions = $dirModel->all();
    $services = $svcModel->all();
    $stats = $pModel->getStats();
    
    // Gestion de l'export CSV
    if (!empty($_GET['export']) && $_GET['export'] === 'csv') {
        $csv = $pModel->exportCsv($personnel);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="personnel_' . date('Y-m-d') . '.csv"');
        echo "\xEF\xBB\xBF" . $csv; // BOM UTF-8
        exit;
    }
    
    require __DIR__ . '/../views/personnel/list.php';
    
} elseif ($action === 'create') {
    $person = [
        'firstname' => '', 'lastname' => '', 'email' => '', 'phone' => '',
        'direction_id' => '', 'service_id' => '', 'poste_id' => '', 'position' => '',
        'status' => 'Actif', 'hire_date' => '', 'salary' => '', 'contract_duration' => '',
        'contract_end' => '', 'notes' => ''
    ];
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST['firstname']) || empty($_POST['lastname'])) {
            $error = 'Le prénom et le nom sont obligatoires.';
        } elseif (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error = 'Veuillez entrer une adresse email valide.';
        } elseif (!empty($_POST['phone']) && !preg_match('/^[\d\s\-\+\(\)]+$/', $_POST['phone'])) {
            $error = 'Le numéro de téléphone n\'est pas valide.';
        } else {
            // Auto-sync direction à partir du service sélectionné
            if (!empty($_POST['service_id'])) {
                $service = $svcModel->find($_POST['service_id']);
                if ($service) {
                    $_POST['direction_id'] = $service['direction_id'];
                }
            }
            
            // Valider que le poste appartient au service si les deux sont spécifiés
            if (!empty($_POST['poste_id']) && !empty($_POST['service_id'])) {
                try {
                    $posteLookup = $posteModel->find($_POST['poste_id']);
                    if ($posteLookup && $posteLookup['service_id'] != $_POST['service_id']) {
                        $error = 'Le poste sélectionné n\'appartient pas au service sélectionné.';
                    }
                } catch (Exception $e) {
                    // Postes table may not exist, ignore
                }
            }
            
            if (!$error) {
                // sanitize contract_duration
                if (isset($_POST['contract_duration'])) {
                    $_POST['contract_duration'] = $_POST['contract_duration'] === '' ? null : (int)$_POST['contract_duration'];
                }
                $newId = $pModel->create($_POST);
                if ($newId) {
                    header('Location: index.php?page=personnel&action=view&id=' . $newId);
                    exit;
                } else {
                    $error = "Une erreur est survenue lors de la création.";
                }
            }
        }
    }
    $directions = $dirModel->all();
    $services = $svcModel->all();
    require __DIR__ . '/../views/personnel/form.php';
    
} elseif ($action === 'edit') {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        header('Location: index.php?page=personnel');
        exit;
    }
    
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST['firstname']) || empty($_POST['lastname'])) {
            $error = 'Le prénom et le nom sont obligatoires.';
        } elseif (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error = 'Veuillez entrer une adresse email valide.';
        } else {
            // Auto-sync direction à partir du service sélectionné
            if (!empty($_POST['service_id'])) {
                $service = $svcModel->find($_POST['service_id']);
                if ($service) {
                    $_POST['direction_id'] = $service['direction_id'];
                }
            }
            
            // Valider que le poste appartient au service si les deux sont spécifiés
            if (!empty($_POST['poste_id']) && !empty($_POST['service_id'])) {
                try {
                    $posteLookup = $posteModel->find($_POST['poste_id']);
                    if ($posteLookup && $posteLookup['service_id'] != $_POST['service_id']) {
                        $error = 'Le poste sélectionné n\'appartient pas au service sélectionné.';
                    }
                } catch (Exception $e) {
                    // Postes table may not exist, ignore
                }
            }
            
            if (!$error) {
                if (isset($_POST['contract_duration'])) {
                    $_POST['contract_duration'] = $_POST['contract_duration'] === '' ? null : (int)$_POST['contract_duration'];
                }
                $pModel->update($id, $_POST);
                header('Location: index.php?page=personnel');
                exit;
            }
        }
    }
    $person = $pModel->find($id);
    $directions = $dirModel->all();
    $services = $svcModel->all();
    require __DIR__ . '/../views/personnel/form.php';
    
} elseif ($action === 'view') {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        header('Location: index.php?page=personnel');
        exit;
    }
    $person = $pModel->find($id);
    require __DIR__ . '/../views/personnel/view.php';
    
} elseif ($action === 'delete') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $pModel->delete($id);
    }
    header('Location: index.php?page=personnel');
    exit;
} else {
    echo 'Action non autorisée';
}
?>