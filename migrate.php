<?php
/**
 * Script de migration pour ajouter les nouveaux champs à la table personnel
 * Exécutez ce script une seule fois pour mettre à jour la base de données
 */

// Configuration et connexion BD
require_once __DIR__ . '/config/db.php';

try {
    echo "🔄 Migration en cours...\n";
    
    // Vérifier si les colonnes existent déjà
    $stmt = $pdo->query("SHOW COLUMNS FROM personnel");
    $columns = [];
    foreach ($stmt->fetchAll() as $col) {
        $columns[] = $col['Field'];
    }
    
    // Ajouter les colonnes manquantes
    $migrations = [
        'email' => "ALTER TABLE personnel ADD COLUMN email VARCHAR(255) UNIQUE DEFAULT NULL AFTER lastname",
        'phone' => "ALTER TABLE personnel ADD COLUMN phone VARCHAR(20) DEFAULT NULL AFTER email",
        'status' => "ALTER TABLE personnel ADD COLUMN status ENUM('Actif', 'Inactif', 'En Congé', 'Retraité') DEFAULT 'Actif' AFTER position",
        'hire_date' => "ALTER TABLE personnel ADD COLUMN hire_date DATE DEFAULT NULL AFTER status",
        'salary' => "ALTER TABLE personnel ADD COLUMN salary DECIMAL(10, 2) DEFAULT NULL AFTER hire_date",
        'notes' => "ALTER TABLE personnel ADD COLUMN notes TEXT DEFAULT NULL AFTER salary",
        'created_at' => "ALTER TABLE personnel ADD COLUMN created_at DATETIME DEFAULT CURRENT_TIMESTAMP AFTER notes",
        'updated_at' => "ALTER TABLE personnel ADD COLUMN updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at",
    ];
    
    $added = 0;
    foreach ($migrations as $col => $sql) {
        if (!in_array($col, $columns)) {
            try {
                $pdo->exec($sql);
                echo "✅ Colonne '$col' ajoutée\n";
                $added++;
            } catch (Exception $e) {
                echo "⚠️  Colonne '$col' : " . $e->getMessage() . "\n";
            }
        } else {
            echo "⏭️  Colonne '$col' existait déjà\n";
        }
    }
    
    // Ajouter les index si manquants
    $indexSql = [
        "CREATE INDEX idx_status ON personnel(status)" => "idx_status",
        "CREATE INDEX idx_service ON personnel(service_id)" => "idx_service",
        "CREATE INDEX idx_direction ON personnel(direction_id)" => "idx_direction",
    ];
    
    foreach ($indexSql as $sql => $indexName) {
        try {
            // Vérifier si l'index existe
            $check = $pdo->query("SHOW INDEX FROM personnel WHERE Key_name = '$indexName'");
            if ($check->rowCount() == 0) {
                $pdo->exec($sql);
                echo "✅ Index '$indexName' créé\n";
                $added++;
            }
        } catch (Exception $e) {
            // Index existe déjà ou erreur
        }
    }
    
    echo "\n✨ Migration terminée!\n";
    echo "Colonnes ajoutées: $added\n";
    echo "La base de données est prête pour la nouvelle version.\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    exit(1);
}

?>
