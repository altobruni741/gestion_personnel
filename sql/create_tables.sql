-- SQL script to create database and tables for Gestion Personnel
CREATE DATABASE IF NOT EXISTS gestion_personnel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gestion_personnel;

CREATE TABLE IF NOT EXISTS directions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  direction_id INT,
  FOREIGN KEY (direction_id) REFERENCES directions(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS personnel (
  id INT AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(100) NOT NULL,
  lastname VARCHAR(100) NOT NULL,
  email VARCHAR(255) UNIQUE,
  phone VARCHAR(20),
  position VARCHAR(150),
  status ENUM('Actif', 'Inactif', 'En Congé', 'Retraité') DEFAULT 'Actif',
  hire_date DATE,
  salary DECIMAL(10, 2),
  notes TEXT,
  service_id INT,
  direction_id INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL,
  FOREIGN KEY (direction_id) REFERENCES directions(id) ON DELETE SET NULL,
  INDEX idx_status (status),
  INDEX idx_service (service_id),
  INDEX idx_direction (direction_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed initial directions and services inspired by the organigram (without Gouverneur)
INSERT INTO directions (name) VALUES
('Secrétariat Général'),
('Direction de la Synergie pour Le Développement (DSD)'),
('Direction de la Valorisation des Potentialités Économiques (DVPE)'),
('Direction de la Préservation de l\'Environnement Écologique (DP2E)'),
('Direction du Développement Humain (DDH)'),
('Direction des Infrastructures (DI)'),
('Direction Administrative et Financière (DAF)'),
('Service de la Programmation et du Suivi-Évaluation (SPSE)');

INSERT INTO services (name, direction_id) VALUES
('Service de la Mobilité et des Échanges', 2),
('Service de l\'Électrification rurale et de l\'Usage multiple de l\'Eau', 2),
('Service de la Bonne Gouvernance', 2),
('Service de la Protection Civile et des Renseignements', 2),
('Service Chargé de la promotion de l\'Agriculture, Elevage, Pêche, Foresterie', 3),
('Service Chargé de la Promotion de l\'Industrie et des Mines', 3),
('Service Chargé de la promotion du Tourisme', 3),
('Service de l\'Intelligence Économique', 3),
('Service chargé de la Protection de l\'Environnement', 4),
('Service de l\'Éducation et du Suivi environnemental', 4),
('Service de l\'Education et de la Formation', 5),
('Service de l\'Amélioration du Cadre de vie', 5),
('Service de la Protection Sociale', 5),
('Service des Études et des Réalisations', 6),
('Service de la Logistique', 6),
('Service des Finances', 7),
('Service des Ressources Financières', 7),
('Service des Ressources Humaines', 7),
('Service de la Comptabilité et de la Logistique', 7);

-- Users table for authentication
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
