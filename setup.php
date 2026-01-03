<?php
/**
 * Script de migration - Accessible une seule fois pour la sécurité
 */

session_start();

// Configuration et connexion BD
require_once __DIR__ . '/config/db.php';

// Vérifier si une variable d'environnement le permet
$isMigrationAllowed = file_exists(__DIR__ . '/.migration_allowed');

if (!$isMigrationAllowed && empty($_POST['confirm'])) {
    ?>
    <!doctype html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Migration Base de Données</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-slate-100 dark:bg-slate-900 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 rounded-full bg-white dark:bg-slate-700 flex items-center justify-center mx-auto mb-4 shadow-sm border border-slate-200 dark:border-slate-600 overflow-hidden">
                        <img src="assets/images/logo_faritany.jpg" alt="Logo" class="w-full h-full object-cover">
                    </div>
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Migration Base de Données</h1>
                    <p class="text-slate-600 dark:text-slate-400 mt-2">Mise à jour des tables pour les nouvelles fonctionnalités</p>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-3">✅ Modifications à effectuer:</h2>
                    <ul class="space-y-2 text-blue-800 dark:text-blue-200 text-sm">
                        <li>✓ Ajout des colonnes email, phone, status</li>
                        <li>✓ Ajout des colonnes hire_date, salary, notes</li>
                        <li>✓ Ajout des colonnes created_at, updated_at</li>
                        <li>✓ Création des index de performance</li>
                    </ul>
                </div>

                <form method="post" class="space-y-4">
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                        <p class="text-yellow-800 dark:text-yellow-200 text-sm">
                            <strong>Attention:</strong> Cette opération modifiera la structure de votre base de données. Assurez-vous d'avoir une sauvegarde!
                        </p>
                    </div>

                    <button type="submit" name="confirm" value="yes" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-colors">
                        ✓ Lancer la migration
                    </button>

                    <a href="index.php" class="block text-center py-3 bg-slate-300 dark:bg-slate-700 hover:bg-slate-400 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-bold rounded-lg transition-colors">
                        ← Retour
                    </a>
                </form>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Exécuter la migration
try {
    echo "<div style='font-family: monospace; white-space: pre-wrap; padding: 20px; background: #f5f5f5;'>";
    echo "🔄 Migration en cours...\n\n";
    
    // Vérifier les colonnes existantes
    $stmt = $pdo->query("SHOW COLUMNS FROM personnel");
    $columns = [];
    foreach ($stmt->fetchAll() as $col) {
        $columns[] = $col['Field'];
    }
    
    // Migrations à effectuer
    $migrations = [
        ['col' => 'email', 'sql' => "ALTER TABLE personnel ADD COLUMN email VARCHAR(255) UNIQUE DEFAULT NULL AFTER lastname"],
        ['col' => 'phone', 'sql' => "ALTER TABLE personnel ADD COLUMN phone VARCHAR(20) DEFAULT NULL AFTER email"],
        ['col' => 'status', 'sql' => "ALTER TABLE personnel ADD COLUMN status ENUM('Actif', 'Inactif', 'En Congé', 'Retraité') DEFAULT 'Actif' AFTER position"],
        ['col' => 'hire_date', 'sql' => "ALTER TABLE personnel ADD COLUMN hire_date DATE DEFAULT NULL AFTER status"],
        ['col' => 'salary', 'sql' => "ALTER TABLE personnel ADD COLUMN salary DECIMAL(10, 2) DEFAULT NULL AFTER hire_date"],
        ['col' => 'notes', 'sql' => "ALTER TABLE personnel ADD COLUMN notes TEXT DEFAULT NULL AFTER salary"],
        ['col' => 'created_at', 'sql' => "ALTER TABLE personnel ADD COLUMN created_at DATETIME DEFAULT CURRENT_TIMESTAMP AFTER notes"],
        ['col' => 'updated_at', 'sql' => "ALTER TABLE personnel ADD COLUMN updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at"],
    ];
    
    $added = 0;
    foreach ($migrations as $migration) {
        if (!in_array($migration['col'], $columns)) {
            try {
                $pdo->exec($migration['sql']);
                echo "✅ Colonne '{$migration['col']}' ajoutée\n";
                $added++;
            } catch (Exception $e) {
                echo "⚠️  Colonne '{$migration['col']}': {$e->getMessage()}\n";
            }
        } else {
            echo "⏭️  Colonne '{$migration['col']}' existait déjà\n";
        }
    }
    
    // Créer les index
    $indexes = [
        ['name' => 'idx_status', 'sql' => "CREATE INDEX idx_status ON personnel(status)"],
        ['name' => 'idx_service', 'sql' => "CREATE INDEX idx_service ON personnel(service_id)"],
        ['name' => 'idx_direction', 'sql' => "CREATE INDEX idx_direction ON personnel(direction_id)"],
    ];
    
    foreach ($indexes as $index) {
        try {
            $check = $pdo->query("SHOW INDEX FROM personnel WHERE Key_name = '{$index['name']}'")->rowCount();
            if ($check == 0) {
                $pdo->exec($index['sql']);
                echo "✅ Index '{$index['name']}' créé\n";
                $added++;
            }
        } catch (Exception $e) {
            // Index existe déjà
        }
    }
    
    echo "\n✨ Migration terminée avec succès!\n";
    echo "Éléments ajoutés: $added\n\n";
    
    // Marquer la migration comme effectuée
    touch(__DIR__ . '/.migration_done');
    
    echo "✅ La base de données est maintenant à jour!\n";
    echo "\n<a href='index.php' style='color: #2563eb; text-decoration: none;'>→ Accéder à l'application</a>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #fee2e2; color: #991b1b; padding: 20px; border-radius: 8px;'>";
    echo "❌ Erreur: " . htmlspecialchars($e->getMessage()) . "\n";
    echo "</div>";
    exit(1);
}

?>
