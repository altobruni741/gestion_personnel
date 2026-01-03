-- Migration: Ajouter la table poste pour une meilleure organisation hiérarchique
-- Direction → Service → Poste → Personnel

ALTER TABLE personnel 
ADD COLUMN IF NOT EXISTS poste_id INT AFTER service_id,
ADD FOREIGN KEY (poste_id) REFERENCES postes(id) ON DELETE SET NULL;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exemple de données pour la hiérarchie
INSERT INTO postes (name, description, service_id) 
SELECT DISTINCT 
  position, 
  CONCAT('Poste de ', position) as description,
  service_id
FROM personnel 
WHERE position IS NOT NULL AND position != '' 
GROUP BY service_id, position
ON DUPLICATE KEY UPDATE updated_at = CURRENT_TIMESTAMP;

-- Créer les index supplémentaires pour optimiser les requêtes
ALTER TABLE personnel ADD INDEX IF NOT EXISTS idx_poste (poste_id);
ALTER TABLE postes ADD INDEX IF NOT EXISTS idx_service_pos (service_id);
