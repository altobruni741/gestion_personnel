<?php
/**
 * Modèle Direction - Gestion des directions
 * Hiérarchie: Direction → Service → Poste → Personnel
 */
class Direction {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Récupère toutes les directions
     */
    public function all() {
        $stmt = $this->pdo->query('SELECT * FROM directions ORDER BY name');
        return $stmt->fetchAll();
    }
    
    /**
     * Récupère une direction par ID
     */
    public function find($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM directions WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Crée une nouvelle direction
     */
    public function create($name) {
        $stmt = $this->pdo->prepare('INSERT INTO directions (name) VALUES (?)');
        return $stmt->execute([$name]);
    }
    
    /**
     * Met à jour une direction
     */
    public function update($id, $name) {
        $stmt = $this->pdo->prepare('UPDATE directions SET name = ? WHERE id = ?');
        return $stmt->execute([$name, $id]);
    }
    
    /**
     * Supprime une direction et cascades les suppressions
     */
    public function delete($id) {
        // Dissocier les employés de la direction
        $stmt = $this->pdo->prepare('UPDATE personnel SET direction_id = NULL WHERE direction_id = ?');
        $stmt->execute([$id]);
        
        // Supprimer les postes de tous les services de cette direction
        $stmt = $this->pdo->prepare(
            'DELETE FROM postes WHERE service_id IN 
             (SELECT id FROM services WHERE direction_id = ?)'
        );
        $stmt->execute([$id]);
        
        // Supprimer les services de cette direction
        $stmt = $this->pdo->prepare('DELETE FROM services WHERE direction_id = ?');
        $stmt->execute([$id]);
        
        // Supprimer la direction
        $stmt = $this->pdo->prepare('DELETE FROM directions WHERE id = ?');
        return $stmt->execute([$id]);
    }
    
    /**
     * Récupère les services d'une direction
     */
    public function getServices($direction_id) {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM services WHERE direction_id = ? ORDER BY name'
        );
        $stmt->execute([$direction_id]);
        return $stmt->fetchAll();
    }
    
    /**
     * Récupère les postes d'une direction (tous les postes de tous les services)
     */
    public function getPostes($direction_id) {
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
     * Récupère les statistiques complètes d'une direction
     */
    public function getStats($id) {
        $stmt = $this->pdo->prepare(
            'SELECT 
                COUNT(DISTINCT s.id) as total_services,
                COUNT(DISTINCT po.id) as total_postes,
                COUNT(DISTINCT p.id) as total_personnel,
                SUM(CASE WHEN p.status = "Actif" THEN 1 ELSE 0 END) as actifs,
                SUM(CASE WHEN p.status = "En Congé" THEN 1 ELSE 0 END) as en_conge,
                SUM(CASE WHEN p.status = "Inactif" THEN 1 ELSE 0 END) as inactifs,
                SUM(CASE WHEN p.status = "Retraité" THEN 1 ELSE 0 END) as retraites
             FROM directions d
             LEFT JOIN services s ON s.direction_id = d.id
             LEFT JOIN postes po ON po.service_id = s.id
             LEFT JOIN personnel p ON p.poste_id = po.id OR (p.direction_id = d.id AND p.poste_id IS NULL)
             WHERE d.id = ?'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Récupère le personnel complet d'une direction
     */
    public function getPersonnel($direction_id) {
        $stmt = $this->pdo->prepare(
            'SELECT DISTINCT p.*, s.name as service_name, po.name as poste_name 
             FROM personnel p 
             LEFT JOIN services s ON p.service_id = s.id 
             LEFT JOIN postes po ON p.poste_id = po.id 
             WHERE p.direction_id = ? OR s.direction_id = ? 
             ORDER BY s.name, p.lastname, p.firstname'
        );
        $stmt->execute([$direction_id, $direction_id]);
        return $stmt->fetchAll();
    }
}
?>