-- Migration: Ajouter la table poste pour une meilleure organisation hiérarchique
-- Direction → Service → Poste → Personnel

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

ALTER TABLE personnel 
ADD COLUMN IF NOT EXISTS poste_id INT AFTER service_id;

-- Add FK only if it doesn't exist (this SQL might need to be run carefully if repeated)
-- Note: pure SQL doesn't have "ADD FOREIGN KEY IF NOT EXISTS" easily without procedures, 
-- but for this file we assume it's run once or the user manages state.
-- We will just try to add it.
SET @dbname = DATABASE();
SET @tablename = "personnel";
SET @constraintname = "personnel_ibfk_poste";
SET @cmd = "ALTER TABLE personnel ADD CONSTRAINT personnel_ibfk_poste FOREIGN KEY (poste_id) REFERENCES postes(id) ON DELETE SET NULL";

SELECT count(*) INTO @exists
FROM information_schema.table_constraints
WHERE table_schema = @dbname
AND table_name = @tablename
AND constraint_name = @constraintname;

SET @cmd = IF(@exists > 0, 'SELECT "Constraint already exists"', @cmd);
PREPARE stmt FROM @cmd;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Exemple de données pour la hiérarchie
INSERT INTO postes (name, description, service_id) 
SELECT DISTINCT 
  position, 
  CONCAT('Poste de ', position) as description,
  service_id
FROM personnel 
WHERE position IS NOT NULL AND position != '' AND service_id IS NOT NULL
GROUP BY service_id, position
ON DUPLICATE KEY UPDATE updated_at = CURRENT_TIMESTAMP;

-- Créer les index supplémentaires pour optimiser les requêtes
ALTER TABLE personnel ADD INDEX IF NOT EXISTS idx_poste (poste_id);
ALTER TABLE postes ADD INDEX IF NOT EXISTS idx_service_pos (service_id);