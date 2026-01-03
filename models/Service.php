<?php
/**
 * Modèle Service - Gestion des services au sein des directions
 * Hiérarchie: Direction → Service → Poste → Personnel
 */
class Service {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Récupère tous les services avec leur direction
     */
    public function all() {
        $stmt = $this->pdo->query(
            'SELECT s.*, d.name as direction_name FROM services s 
             LEFT JOIN directions d ON s.direction_id = d.id 
             ORDER BY d.name, s.name'
        );
        return $stmt->fetchAll();
    }
    
    /**
     * Récupère un service par ID
     */
    public function find($id) {
        $stmt = $this->pdo->prepare(
            'SELECT s.*, d.name as direction_name FROM services s 
             LEFT JOIN directions d ON s.direction_id = d.id 
             WHERE s.id = ?'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Récupère les services d'une direction
     */
    public function byDirection($direction_id) {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM services WHERE direction_id = ? ORDER BY name'
        );
        $stmt->execute([$direction_id]);
        return $stmt->fetchAll();
    }
    
    /**
     * Crée un nouveau service
     */
    public function create($name, $direction_id) {
        $stmt = $this->pdo->prepare(
            'INSERT INTO services (name, direction_id) VALUES (?, ?)'
        );
        return $stmt->execute([$name, $direction_id]);
    }
    
    /**
     * Met à jour un service
     */
    public function update($id, $name, $direction_id) {
        $stmt = $this->pdo->prepare(
            'UPDATE services SET name = ?, direction_id = ? WHERE id = ?'
        );
        return $stmt->execute([$name, $direction_id, $id]);
    }
    
    /**
     * Supprime un service et les postes/personnel associés
     */
    public function delete($id) {
        // Dissocier les employés du service
        $stmt = $this->pdo->prepare('UPDATE personnel SET service_id = NULL WHERE service_id = ?');
        $stmt->execute([$id]);
        
        // Supprimer les postes du service
        $stmt = $this->pdo->prepare('DELETE FROM postes WHERE service_id = ?');
        $stmt->execute([$id]);
        
        // Supprimer le service
        $stmt = $this->pdo->prepare('DELETE FROM services WHERE id = ?');
        return $stmt->execute([$id]);
    }
    
    /**
     * Récupère les statistiques d'un service
     */
    public function getStats($id) {
        $stmt = $this->pdo->prepare(
            'SELECT 
                COUNT(DISTINCT p.id) as total_personnel,
                COUNT(DISTINCT po.id) as total_postes,
                SUM(CASE WHEN p.status = "Actif" THEN 1 ELSE 0 END) as actifs
             FROM services s 
             LEFT JOIN postes po ON po.service_id = s.id 
             LEFT JOIN personnel p ON p.poste_id = po.id 
             WHERE s.id = ?'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Récupère tous les postes d'un service
     */
    public function getPostes($service_id) {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM postes WHERE service_id = ? ORDER BY name'
        );
        $stmt->execute([$service_id]);
        return $stmt->fetchAll();
    }
}
?>