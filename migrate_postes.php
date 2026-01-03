<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Migration Postes - Gestion Personnel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { overflow-y: auto; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800">

<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="max-w-2xl w-full">
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl p-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                Migration: Ajout de la table Postes
            </h1>
            <p class="text-slate-600 dark:text-slate-400 mb-6">
                Organisation hiérarchique: Direction → Service → Poste → Personnel
            </p>

            <?php
                require_once __DIR__ . '/config/db.php';
                require_once __DIR__ . '/models/Poste.php';

                $migration_flag = __DIR__ . '/.migration_postes_done';
                $success = false;
                $errors = [];
                $messages = [];

                // Vérifier si la migration a déjà été effectuée
                if (file_exists($migration_flag) && !isset($_POST['force_migrate'])) {
                    echo '<div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6 mb-6">';
                    echo '<h2 class="text-lg font-bold text-green-900 dark:text-green-100 mb-2">✓ Migration déjà effectuée</h2>';
                    echo '<p class="text-green-800 dark:text-green-200 mb-4">La table postes a déjà été créée. Votre application est à jour.</p>';
                    echo '</div>';
                } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_migration'])) {
                    try {
                        echo '<div class="space-y-4 mb-6">';

                        // 1. Créer la table postes
                        echo '<div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">';
                        echo '<p class="text-blue-900 dark:text-blue-100 font-medium mb-2">⏳ Étape 1/4: Création de la table postes...</p>';

                        $sql_create = '
                            CREATE TABLE IF NOT EXISTS postes (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(150) NOT NULL,
                                description TEXT,
                                service_id INT NOT NULL,
                                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
                                INDEX idx_service (service_id),
                                UNIQUE KEY unique_poste_per_service (name, service_id)
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
                        ';

                        $pdo->exec($sql_create);
                        echo '<p class="text-green-800 dark:text-green-200">✓ Table postes créée</p>';
                        echo '</div>';

                        // 2. Ajouter la colonne poste_id à personnel
                        echo '<div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">';
                        echo '<p class="text-blue-900 dark:text-blue-100 font-medium mb-2">⏳ Étape 2/4: Ajout colonne poste_id...</p>';

                        $stmt = $pdo->query("SHOW COLUMNS FROM personnel LIKE 'poste_id'");
                        if ($stmt->rowCount() == 0) {
                            $pdo->exec('ALTER TABLE personnel ADD COLUMN poste_id INT AFTER service_id');
                            $pdo->exec('ALTER TABLE personnel ADD FOREIGN KEY (poste_id) REFERENCES postes(id) ON DELETE SET NULL');
                            echo '<p class="text-green-800 dark:text-green-200">✓ Colonne poste_id ajoutée</p>';
                        } else {
                            echo '<p class="text-amber-800 dark:text-amber-200">⚠ Colonne poste_id existe déjà</p>';
                        }
                        echo '</div>';

                        // 3. Créer les postes à partir des positions existantes
                        echo '<div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">';
                        echo '<p class="text-blue-900 dark:text-blue-100 font-medium mb-2">⏳ Étape 3/4: Migration des postes existants...</p>';

                        $stmt = $pdo->query(
                            'SELECT DISTINCT position, service_id FROM personnel 
                             WHERE position IS NOT NULL AND position != "" 
                             GROUP BY service_id, position'
                        );
                        $positions = $stmt->fetchAll();

                        $inserted = 0;
                        foreach ($positions as $pos) {
                            $check = $pdo->prepare(
                                'SELECT id FROM postes WHERE name = ? AND service_id = ?'
                            );
                            $check->execute([$pos['position'], $pos['service_id']]);
                            
                            if ($check->rowCount() == 0) {
                                $insert = $pdo->prepare(
                                    'INSERT INTO postes (name, description, service_id) 
                                     VALUES (?, ?, ?)'
                                );
                                $insert->execute([
                                    $pos['position'],
                                    'Poste: ' . $pos['position'],
                                    $pos['service_id']
                                ]);
                                $inserted++;
                            }
                        }

                        echo '<p class="text-green-800 dark:text-green-200">✓ ' . count($positions) . ' postes créés (' . $inserted . ' nouveaux)</p>';
                        echo '</div>';

                        // 4. Lier les employés à leurs postes
                        echo '<div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">';
                        echo '<p class="text-blue-900 dark:text-blue-100 font-medium mb-2">⏳ Étape 4/4: Liaison personnel ↔ postes...</p>';

                        $stmt = $pdo->query(
                            'SELECT p.id, p.position, p.service_id FROM personnel p 
                             WHERE p.position IS NOT NULL AND p.poste_id IS NULL'
                        );
                        $personnel = $stmt->fetchAll();

                        $linked = 0;
                        foreach ($personnel as $emp) {
                            $poste_stmt = $pdo->prepare(
                                'SELECT id FROM postes WHERE name = ? AND service_id = ?'
                            );
                            $poste_stmt->execute([$emp['position'], $emp['service_id']]);
                            $poste = $poste_stmt->fetch();

                            if ($poste) {
                                $update = $pdo->prepare(
                                    'UPDATE personnel SET poste_id = ? WHERE id = ?'
                                );
                                $update->execute([$poste['id'], $emp['id']]);
                                $linked++;
                            }
                        }

                        echo '<p class="text-green-800 dark:text-green-200">✓ ' . $linked . ' employés liés à leurs postes</p>';
                        echo '</div>';

                        // Créer le fichier de flag
                        file_put_contents($migration_flag, date('Y-m-d H:i:s'));

                        // Succès
                        echo '<div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6 text-center mt-6">';
                        echo '<h2 class="text-2xl font-bold text-green-900 dark:text-green-100 mb-2">✓ Migration réussie!</h2>';
                        echo '<p class="text-green-800 dark:text-green-200 mb-4">La table postes a été créée et configurée avec succès.</p>';
                        echo '<p class="text-sm text-green-700 dark:text-green-300 mb-6">';
                        echo $inserted . ' nouveaux postes créés • ' . $linked . ' employés reliés';
                        echo '</p>';
                        echo '<a href="index.php?page=poste&action=list" class="inline-block px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition">';
                        echo 'Accéder à la gestion des postes →';
                        echo '</a>';
                        echo '</div>';

                        $success = true;

                    } catch (Exception $e) {
                        echo '<div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6">';
                        echo '<h2 class="text-lg font-bold text-red-900 dark:text-red-100 mb-2">✗ Erreur lors de la migration</h2>';
                        echo '<p class="text-red-800 dark:text-red-200 mb-4">' . h($e->getMessage()) . '</p>';
                        echo '</div>';
                    }
                } else {
                    // Page de confirmation
                    if (!file_exists($migration_flag)) {
                        echo '<div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-6">';
                        echo '<h2 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-3">📋 Cette migration va:</h2>';
                        echo '<ul class="space-y-2 text-blue-800 dark:text-blue-200">';
                        echo '<li>✓ Créer la table <code>postes</code></li>';
                        echo '<li>✓ Ajouter la colonne <code>poste_id</code> à la table personnel</li>';
                        echo '<li>✓ Importer les positions existantes comme postes</li>';
                        echo '<li>✓ Lier les employés à leurs postes</li>';
                        echo '<li>✓ Mettre en place les indexes et relations</li>';
                        echo '</ul>';
                        echo '</div>';

                        echo '<div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6 mb-6">';
                        echo '<h2 class="text-lg font-bold text-yellow-900 dark:text-yellow-100 mb-2">⚠️ Recommandations</h2>';
                        echo '<ul class="space-y-2 text-yellow-800 dark:text-yellow-200 text-sm">';
                        echo '<li>• Faire une sauvegarde de la base de données avant</li>';
                        echo '<li>• Vérifier que personne n\'utilise l\'application</li>';
                        echo '<li>• Cette migration ne supprimera aucune donnée existante</li>';
                        echo '</ul>';
                        echo '</div>';

                        echo '<form method="POST" class="space-y-4">';
                        echo '<input type="hidden" name="confirm_migration" value="1">';
                        echo '<button type="submit" class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold transition">';
                        echo '▶ Lancer la migration';
                        echo '</button>';
                        echo '</form>';
                    }
                }
            ?>

            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    📚 Consultez <a href="HIERARCHIE.md" class="text-blue-600 dark:text-blue-400 hover:underline">HIERARCHIE.md</a> 
                    pour comprendre la nouvelle structure.
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
