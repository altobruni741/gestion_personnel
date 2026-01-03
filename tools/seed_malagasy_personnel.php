<?php
require_once __DIR__ . '/../config/db.php';

echo "🌱 Seeding 60 Malagasy Personnel...\n";

$firstnames = ['Andry', 'Toky', 'Sitraka', 'Mamy', 'Niry', 'Faly', 'Hasina', 'Njaka', 'Rindra', 'Soa', 'Lalaina', 'Hoby', 'Faniry', 'Tiana', 'Voahirana', 'Nirina', 'Bakoly', 'Noro', 'Onja', 'Tahina', 'Fitiavana', 'Aina', 'Solofo', 'Heriniaina', 'Lova', 'Tojo', 'Tsiry', 'Vola', 'Mino', 'Narindra'];
$lastnames = ['Rakotomalala', 'Randrianarisoa', 'Razafindrakoto', 'Rasoanaivo', 'Andrianarivo', 'Rakotonirina', 'Ramanantsoa', 'Ratsimbazafy', 'Rabemananjara', 'Randriamampionona', 'Rasolofomanana', 'Rakotomamonjy', 'Randriamanantena', 'Razafimahatratra', 'Rakotoarisoa', 'Rafalimanana', 'Raharimalala', 'Rakotondrainibe', 'Randriambolona', 'Ralaivao'];

try {
    // Get all available postes with their service and direction
    $stmt = $pdo->query(
        "SELECT p.id as poste_id, p.service_id, s.direction_id 
        FROM postes p 
        JOIN services s ON p.service_id = s.id
    ");
    $postes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($postes)) {
        die("❌ No postes found. Please run seed_postes.php first.\n");
    }

    $inserted = 0;
    $statuses = ['Actif', 'Actif', 'Actif', 'Actif', 'En Congé', 'Inactif'];

    for ($i = 0; $i < 60; $i++) {
        $fname = $firstnames[array_rand($firstnames)];
        $lname = $lastnames[array_rand($lastnames)];
        $email = strtolower($fname . '.' . str_replace(' ', '', $lname) . $i . '@example.mg');
        $phone = '034 ' . rand(10, 99) . ' ' . rand(100, 999) . ' ' . rand(10, 99);
        
        $poste = $postes[array_rand($postes)];
        $status = $statuses[array_rand($statuses)];
        $salary = rand(400000, 2500000);
        $hireDate = date('Y-m-d', strtotime('-' . rand(30, 3000) . ' days'));
        
        // Random contract duration
        $duration = (rand(0, 1) > 0.5) ? rand(180, 730) : null;
        $endDate = null;
        if ($duration) {
            $endDate = date('Y-m-d', strtotime($hireDate . ' +' . $duration . ' days'));
        }

        $sql = "INSERT INTO personnel (firstname, lastname, email, phone, status, hire_date, salary, service_id, direction_id, poste_id, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $ins = $pdo->prepare($sql);
        if ($ins->execute([
            $fname, $lname, $email, $phone, $status, $hireDate, $salary, 
            $poste['service_id'], $poste['direction_id'], $poste['poste_id']
        ])) {
            $inserted++;
        }
    }

    echo "✅ Success! $inserted Malagasy employees added to the database.\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
