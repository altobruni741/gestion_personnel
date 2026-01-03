<?php
/**
 * Modèle Personnel avec fonctionnalités complètes
 */
class Personnel {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Récupère tous les employés avec leurs relations complètes
     */
    public function all($filters = []) {
        // Vérifier si la table postes existe
        $check_postes = $this->tableExists('postes');
        
        $query = 'SELECT p.*, s.name as service_name, d.name as direction_name' .
                 ($check_postes ? ', po.name as poste_name' : '') . '
                  FROM personnel p 
                  LEFT JOIN services s ON p.service_id = s.id 
                  LEFT JOIN directions d ON p.direction_id = d.id' .
                 ($check_postes ? ' LEFT JOIN postes po ON p.poste_id = po.id' : '') . '
                  WHERE 1=1';
        
        $params = [];
        
        // Filtre par statut
        if (!empty($filters['status'])) {
            $query .= ' AND p.status = ?';
            $params[] = $filters['status'];
        }
        
        // Filtre par direction
        if (!empty($filters['direction_id'])) {
            $query .= ' AND (p.direction_id = ? OR d.id = ?)';
            $params[] = $filters['direction_id'];
            $params[] = $filters['direction_id'];
        }
        
        // Filtre par service
        if (!empty($filters['service_id'])) {
            $query .= ' AND p.service_id = ?';
            $params[] = $filters['service_id'];
        }
        
        // Filtre par poste (si la table existe)
        if (!empty($filters['poste_id']) && $check_postes) {
            $query .= ' AND p.poste_id = ?';
            $params[] = $filters['poste_id'];
        }
        
        // Recherche par nom ou prénom
        if (!empty($filters['search'])) {
            $query .= ' AND (p.firstname LIKE ? OR p.lastname LIKE ? OR p.email LIKE ?)';
            $search = '%' . $filters['search'] . '%';
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }
        
        $query .= ' ORDER BY d.name, s.name' . ($check_postes ? ', po.name' : '') . ', p.lastname, p.firstname';
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Récupère un employé par ID
     */
    public function find($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM personnel WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Crée un nouvel employé avec support du poste
     */
    public function create($data) {
        // Construire dynamiquement la requête si les colonnes existent
        $cols = ['firstname','lastname','email','phone','position','status','hire_date','salary','notes','service_id','direction_id','poste_id'];
        $params = [];
        $placeholders = [];

        foreach ($cols as $c) {
            $placeholders[] = '?';
            $params[] = $data[$c] ?? null;
        }

        // gérer contract_duration et contract_end si les colonnes existent
        if ($this->columnExists('personnel','contract_duration')) {
            $cols[] = 'contract_duration';
            $placeholders[] = '?';
            $params[] = isset($data['contract_duration']) ? (int)$data['contract_duration'] : null;
        }
        if ($this->columnExists('personnel','contract_end')) {
            // calculer contract_end si possible
            $contractEnd = null;
            if (!empty($data['hire_date']) && !empty($data['contract_duration'])) {
                $contractEnd = date('Y-m-d', strtotime($data['hire_date'] . ' +' . (int)$data['contract_duration'] . ' days'));
            }
            $cols[] = 'contract_end';
            $placeholders[] = '?';
            $params[] = $contractEnd;
        }

        $sql = 'INSERT INTO personnel (' . implode(',', $cols) . ') VALUES (' . implode(',', $placeholders) . ')';
        $stmt = $this->pdo->prepare($sql);
        
        if ($stmt->execute($params)) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }
    
    /**
     * Met à jour un employé avec support du poste
     */
    public function update($id, $data) {
        // Construire dynamiquement la requête de mise à jour
        $cols = ['firstname','lastname','email','phone','position','status','hire_date','salary','notes','service_id','direction_id','poste_id'];
        $set = [];
        $params = [];

        foreach ($cols as $c) {
            $set[] = "$c = ?";
            $params[] = $data[$c] ?? null;
        }

        if ($this->columnExists('personnel','contract_duration')) {
            $set[] = 'contract_duration = ?';
            $params[] = isset($data['contract_duration']) ? (int)$data['contract_duration'] : null;
        }
        if ($this->columnExists('personnel','contract_end')) {
            $contractEnd = null;
            if (!empty($data['hire_date']) && !empty($data['contract_duration'])) {
                $contractEnd = date('Y-m-d', strtotime($data['hire_date'] . ' +' . (int)$data['contract_duration'] . ' days'));
            }
            $set[] = 'contract_end = ?';
            $params[] = $contractEnd;
        }

        $params[] = $id;
        $sql = 'UPDATE personnel SET ' . implode(',', $set) . ' WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Supprime un employé
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM personnel WHERE id = ?');
        return $stmt->execute([$id]);
    }
    
    /**
     * Obtient les statistiques
     */
    public function getStats() {
        $stats = [];
        
        // Total personnel actif
        $stmt = $this->pdo->query('SELECT COUNT(*) as count FROM personnel WHERE status = "Actif"');
        $stats['active'] = $stmt->fetch()['count'];
        
        // Personnel par direction
        $stmt = $this->pdo->query(' 
            SELECT d.name, COUNT(p.id) as count 
            FROM directions d 
            LEFT JOIN personnel p ON d.id = p.direction_id AND p.status = "Actif"
            GROUP BY d.id
        ');
        $stats['by_direction'] = $stmt->fetchAll();
        
        // Personnel par service
        $stmt = $this->pdo->query(' 
            SELECT s.name, COUNT(p.id) as count 
            FROM services s 
            LEFT JOIN personnel p ON s.id = p.service_id AND p.status = "Actif"
            GROUP BY s.id
        ');
        $stats['by_service'] = $stmt->fetchAll();
        
        // Total personnel
        $stmt = $this->pdo->query('SELECT COUNT(*) as count FROM personnel');
        $stats['total'] = $stmt->fetch()['count'];
        
        return $stats;
    }
    
    /**
     * Recherche personnalisée
     */
    public function search($query) {
        $stmt = $this->pdo->prepare(' 
            SELECT p.*, s.name as service_name, d.name as direction_name
            FROM personnel p
            LEFT JOIN services s ON p.service_id = s.id
            LEFT JOIN directions d ON p.direction_id = d.id
            WHERE p.firstname LIKE ? OR p.lastname LIKE ? OR p.email LIKE ? OR p.position LIKE ?
            ORDER BY p.lastname, p.firstname
        ');
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    /**
     * Export en CSV avec hiérarchie complète
     */
    public function exportCsv($personnel) {
        $output = "\xEF\xBB\xBF"; // UTF-8 BOM
        $output .= "Prénom,Nom,Email,Téléphone,Poste,Statut,Date d'embauche,Salaire,Direction,Service\n";
        
        foreach ($personnel as $p) {
            $output .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                $p['firstname'] ?? '',
                $p['lastname'] ?? '',
                $p['email'] ?? '',
                $p['phone'] ?? '',
                $p['poste_name'] ?? ($p['position'] ?? ''),
                $p['status'] ?? '',
                $p['hire_date'] ?? '',
                $p['salary'] ?? '',
                $p['direction_name'] ?? '',
                $p['service_name'] ?? ''
            );
        }
        
        return $output;
    }
    
    /**
     * Récupère le personnel d'un poste
     */
    public function byPoste($poste_id) {
        if (!$this->tableExists('postes')) {
            return [];
        }
        
        $stmt = $this->pdo->prepare(' 
            SELECT p.*, s.name as service_name, d.name as direction_name, po.name as poste_name 
            FROM personnel p 
            LEFT JOIN services s ON p.service_id = s.id 
            LEFT JOIN directions d ON p.direction_id = d.id 
            LEFT JOIN postes po ON p.poste_id = po.id 
            WHERE p.poste_id = ? 
            ORDER BY p.lastname, p.firstname
        ');
        $stmt->execute([$poste_id]);
        return $stmt->fetchAll();
    }
    
    /**
     * Vérifier si une table existe
     */
    private function tableExists($tableName) {
        try {
            $stmt = $this->pdo->query("SHOW TABLES LIKE '$tableName'");
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Vérifier si une colonne existe dans une table
     */
    public function columnExists($table, $column) {
        try {
            $stmt = $this->pdo->prepare("SHOW COLUMNS FROM `$table` LIKE ?");
            $stmt->execute([$column]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>