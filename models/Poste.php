<?php
/**
 * Modèle Poste - Gestion des postes au sein des services
 * Hiérarchie: Direction → Service → Poste → Personnel
 */
class Poste {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Récupère tous les postes avec leurs services
     */
    public function all($filters = []) {
        $query = 'SELECT p.*, s.name as service_name, d.name as direction_name 
                  FROM postes p 
                  INNER JOIN services s ON p.service_id = s.id 
                  LEFT JOIN directions d ON s.direction_id = d.id 
                  WHERE 1=1';
        
        $params = [];
        
        // Filtre par direction
        if (!empty($filters['direction_id'])) {
            $query .= ' AND d.id = ?';
            $params[] = $filters['direction_id'];
        }
        
        // Filtre par service
        if (!empty($filters['service_id'])) {
            $query .= ' AND p.service_id = ?';
            $params[] = $filters['service_id'];
        }
        
        $query .= ' ORDER BY d.name, s.name, p.name';
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Récupère un poste par ID avec ses détails
     */
    public function find($id) {
        $stmt = $this->pdo->prepare(
            'SELECT p.*, s.name as service_name, s.direction_id, d.name as direction_name 
             FROM postes p 
             INNER JOIN services s ON p.service_id = s.id 
             LEFT JOIN directions d ON s.direction_id = d.id 
             WHERE p.id = ?'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Récupère les postes d'un service
     */
    public function byService($service_id) {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM postes WHERE service_id = ? ORDER BY name'
        );
        $stmt->execute([$service_id]);
        return $stmt->fetchAll();
    }
    
    /**
     * Récupère les postes d'une direction
     */
    public function byDirection($direction_id) {
        $stmt = $this->pdo->prepare(
            'SELECT p.*, s.name as service_name 
             FROM postes p 
             INNER JOIN services s ON p.service_id = s.id 
             WHERE s.direction_id = ? 
             ORDER BY s.name, p.name'
        );
        $stmt->execute([$direction_id]);
        return $stmt->fetchAll();
    }
    
    /**
     * Crée un nouveau poste
     */
    public function create($data) {
        $required = ['name', 'service_id'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception("Le champ $field est requis");
            }
        }
        
        $stmt = $this->pdo->prepare(
            'INSERT INTO postes (name, description, service_id) 
             VALUES (?, ?, ?)'
        );
        
        return $stmt->execute([
            $data['name'],
            $data['description'] ?? null,
            $data['service_id']
        ]);
    }
    
    /**
     * Met à jour un poste
     */
    public function update($id, $data) {
        $stmt = $this->pdo->prepare(
            'UPDATE postes SET name = ?, description = ?, service_id = ? 
             WHERE id = ?'
        );
        
        return $stmt->execute([
            $data['name'] ?? null,
            $data['description'] ?? null,
            $data['service_id'] ?? null,
            $id
        ]);
    }
    
    /**
     * Supprime un poste
     */
    public function delete($id) {
        // Dissocier les employés du poste
        $stmt = $this->pdo->prepare('UPDATE personnel SET poste_id = NULL WHERE poste_id = ?');
        $stmt->execute([$id]);
        
        // Supprimer le poste
        $stmt = $this->pdo->prepare('DELETE FROM postes WHERE id = ?');
        return $stmt->execute([$id]);
    }
    
    /**
     * Récupère les statistiques d'un poste (nombre d'employés)
     */
    public function getStats($id) {
        $stmt = $this->pdo->prepare(
            'SELECT 
                COUNT(p.id) as total,
                SUM(CASE WHEN p.status = "Actif" THEN 1 ELSE 0 END) as actifs,
                SUM(CASE WHEN p.status = "En Congé" THEN 1 ELSE 0 END) as en_conge,
                SUM(CASE WHEN p.status = "Inactif" THEN 1 ELSE 0 END) as inactifs,
                SUM(CASE WHEN p.status = "Retraité" THEN 1 ELSE 0 END) as retraites
             FROM personnel p 
             WHERE p.poste_id = ?'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Récupère les employés d'un poste
     */
    public function getPersonnel($poste_id) {
        $stmt = $this->pdo->prepare(
            'SELECT p.*, s.name as service_name, d.name as direction_name 
             FROM personnel p 
             LEFT JOIN services s ON p.service_id = s.id 
             LEFT JOIN directions d ON p.direction_id = d.id 
             WHERE p.poste_id = ? 
             ORDER BY p.lastname, p.firstname'
        );
        $stmt->execute([$poste_id]);
        return $stmt->fetchAll();
    }
}
?>
