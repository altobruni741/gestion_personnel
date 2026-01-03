<?php
require_once __DIR__ . '/../config/db.php';

echo "🌱 Seeding Postes...\n";

try {
    // Get all services
    $stmt = $pdo->query("SELECT id, name FROM services");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $postesCreated = 0;

    foreach ($services as $service) {
        $serviceId = $service['id'];
        $serviceName = $service['name'];

        // Define standard posts for every service
        $standardPostes = [
            'Chef de Service' => "Responsable du " . $serviceName,
            'Assistant(e) de Service' => "Assistance administrative pour le " . $serviceName
        ];

        // Define specific posts based on keywords
        $specificPostes = [];
        
        if (stripos($serviceName, 'Finances') !== false || stripos($serviceName, 'Comptabilité') !== false) {
            $specificPostes = [
                'Comptable' => 'Gestion comptable',
                'Agent de Recouvrement' => 'Suivi des recettes',
                'Auditeur Interne' => 'Contrôle financier'
            ];
        } elseif (stripos($serviceName, 'Ressources Humaines') !== false) {
            $specificPostes = [
                'Gestionnaire RH' => 'Gestion du personnel',
                'Chargé de Formation' => 'Formation et développement',
                'Juriste Droit Social' => 'Conseil juridique RH'
            ];
        } elseif (stripos($serviceName, 'Logistique') !== false) {
            $specificPostes = [
                'Agent Logistique' => 'Gestion des stocks et matériel',
                'Chauffeur' => 'Transport',
                'Magasinier' => 'Gestion de l\'entrepôt'
            ];
        } elseif (stripos($serviceName, 'Informatique') !== false || stripos($serviceName, 'Numérique') !== false) {
             $specificPostes = [
                'Développeur Full Stack' => 'Développement applications',
                'Technicien Réseau' => 'Maintenance réseau',
                'Administrateur Système' => 'Gestion des serveurs'
            ];
        } elseif (stripos($serviceName, 'Agriculture') !== false || stripos($serviceName, 'Elevage') !== false) {
             $specificPostes = [
                'Ingénieur Agronome' => 'Expertise agricole',
                'Technicien Agricole' => 'Support terrain',
                'Vétérinaire' => 'Santé animale'
            ];
        } elseif (stripos($serviceName, 'Environnement') !== false) {
             $specificPostes = [
                'Expert Environnemental' => 'Études d\'impact',
                'Garde Forestier' => 'Surveillance',
                'Technicien Assainissement' => 'Gestion des déchets'
            ];
        } elseif (stripos($serviceName, 'Education') !== false) {
             $specificPostes = [
                'Conseiller Pédagogique' => 'Support aux enseignants',
                'Planificateur' => 'Planification scolaire'
            ];
        } elseif (stripos($serviceName, 'Communication') !== false) {
             $specificPostes = [
                'Chargé de Communication' => 'Relations publiques',
                'Community Manager' => 'Gestion réseaux sociaux'
            ];
        } else {
            // Default technical roles for other services
            $specificPostes = [
                'Agent Administratif' => 'Support administratif',
                'Chargé d\'Études' => 'Analyse et rapports',
                'Secrétaire' => 'Accueil et secrétariat'
            ];
        }

        $allPostes = array_merge($standardPostes, $specificPostes);

        foreach ($allPostes as $name => $desc) {
            // Check if exists
            $check = $pdo->prepare("SELECT id FROM postes WHERE name = ? AND service_id = ?");
            $check->execute([$name, $serviceId]);
            
            if (!$check->fetch()) {
                $ins = $pdo->prepare("INSERT INTO postes (name, description, service_id) VALUES (?, ?, ?)");
                $ins->execute([$name, $desc, $serviceId]);
                $postesCreated++;
                // echo "  + Created '$name' in '$serviceName'\n";
            }
        }
    }

    echo "✅ Success! $postesCreated postes created.\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
