<?php
// Migration: ajouter les colonnes contract_duration (INT) et contract_end (DATE)
require_once __DIR__ . '/config/db.php';

$flag = __DIR__ . '/.migration_contracts_done';
if (file_exists($flag)) {
    echo "Migration contrats déjà effectuée.";
    exit;
}

try {
    // ajouter contract_duration
    $stmt = $pdo->query("SHOW COLUMNS FROM personnel LIKE 'contract_duration'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE personnel ADD COLUMN contract_duration INT NULL AFTER salary");
        echo "Ajout de la colonne contract_duration... OK<br>";
    } else {
        echo "La colonne contract_duration existe déjà.<br>";
    }

    // ajouter contract_end
    $stmt = $pdo->query("SHOW COLUMNS FROM personnel LIKE 'contract_end'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE personnel ADD COLUMN contract_end DATE NULL AFTER contract_duration");
        echo "Ajout de la colonne contract_end... OK<br>";
    } else {
        echo "La colonne contract_end existe déjà.<br>";
    }

    // Calculer contract_end pour les enregistrements existants
    $stmt = $pdo->query("SELECT id, hire_date, contract_duration FROM personnel WHERE contract_duration IS NOT NULL AND (contract_end IS NULL OR contract_end = '0000-00-00')");
    $rows = $stmt->fetchAll();
    $updated = 0;
    foreach ($rows as $r) {
        if (!empty($r['hire_date']) && !empty($r['contract_duration'])) {
            $end = date('Y-m-d', strtotime($r['hire_date'] . " +{$r['contract_duration']} days"));
            $u = $pdo->prepare("UPDATE personnel SET contract_end = ? WHERE id = ?");
            $u->execute([$end, $r['id']]);
            $updated++;
        }
    }
    echo "Mise à jour des contract_end: {$updated} enregistrements.<br>";

    // créer flag
    file_put_contents($flag, date('c'));
    echo "Migration terminée.";

} catch (Exception $e) {
    echo "Erreur: " . htmlspecialchars($e->getMessage());
}

?>
