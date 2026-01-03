-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 03 jan. 2026 à 10:55
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_personnel`
--

-- --------------------------------------------------------

--
-- Structure de la table `directions`
--

CREATE TABLE `directions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `directions`
--

INSERT INTO `directions` (`id`, `name`) VALUES
(1, 'Secrétariat Général'),
(2, 'Direction de la Synergie pour Le Développement (DSD)'),
(3, 'Direction de la Valorisation des Potentialités Économiques (DVPE)'),
(4, 'Direction de la Préservation de l\'Environnement Écologique (DP2E)'),
(5, 'Direction du Développement Humain (DDH)'),
(6, 'Direction des Infrastructures (DI)'),
(7, 'Direction Administrative et Financière (DAF)'),
(8, 'Service de la Programmation et du Suivi-Évaluation (SPSE)'),
(9, 'DIrection de la Centre immatriculation ');

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE `personnel` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `position` varchar(150) DEFAULT NULL,
  `status` enum('Actif','Inactif','En Congé','Retraité') DEFAULT 'Actif',
  `hire_date` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `contract_duration` int(11) DEFAULT NULL,
  `contract_end` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `service_id` int(11) DEFAULT NULL,
  `poste_id` int(11) DEFAULT NULL,
  `direction_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `personnel`
--

INSERT INTO `personnel` (`id`, `firstname`, `lastname`, `email`, `phone`, `position`, `status`, `hire_date`, `salary`, `contract_duration`, `contract_end`, `notes`, `created_at`, `updated_at`, `service_id`, `poste_id`, `direction_id`) VALUES
(8, 'Test', 'User', 'test.user@example.com', '0123456789', 'Test Position', 'Actif', '2026-01-03', 50000.00, NULL, NULL, 'Created via test script', '2026-01-03 12:02:34', '2026-01-03 12:02:34', 1, 1, 1),
(9, 'Nicolas', 'pepe', 'pepe@gmail.com', '+33261897812', 'stagiaire', 'Actif', '2026-01-01', 50000000.00, 2, '2026-01-03', '', '2026-01-03 12:19:10', '2026-01-03 12:19:10', 9, 45, 4),
(10, 'Njaka', 'Randriamampionona', 'njaka.randriamampionona0@example.mg', '034 48 981 83', NULL, 'Actif', '2020-12-12', 854800.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 19, 92, 7),
(11, 'Vola', 'Rasoanaivo', 'vola.rasoanaivo1@example.mg', '034 42 858 45', NULL, 'Actif', '2020-03-28', 827474.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 16, 80, 7),
(12, 'Narindra', 'Rasolofomanana', 'narindra.rasolofomanana2@example.mg', '034 80 848 11', NULL, 'Actif', '2018-06-16', 568777.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 16, 80, 7),
(13, 'Mamy', 'Andrianarivo', 'mamy.andrianarivo3@example.mg', '034 93 804 50', NULL, 'Actif', '2022-05-10', 2348672.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 16, 1, 7),
(14, 'Noro', 'Rakotoarisoa', 'noro.rakotoarisoa4@example.mg', '034 22 944 29', NULL, 'Inactif', '2024-01-20', 1380853.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 10, 51, 4),
(15, 'Tsiry', 'Randriambolona', 'tsiry.randriambolona5@example.mg', '034 77 808 88', NULL, 'Actif', '2021-04-01', 2301550.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 7, 32, 3),
(16, 'Tahina', 'Andrianarivo', 'tahina.andrianarivo6@example.mg', '034 66 494 75', NULL, 'Actif', '2019-03-09', 605283.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 10, 51, 4),
(17, 'Faniry', 'Ratsimbazafy', 'faniry.ratsimbazafy7@example.mg', '034 19 348 43', NULL, 'En Congé', '2022-03-09', 699464.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 15, 73, 6),
(18, 'Mamy', 'Rakotomamonjy', 'mamy.rakotomamonjy8@example.mg', '034 11 576 12', NULL, 'En Congé', '2024-02-26', 1884282.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 14, 68, 6),
(19, 'Tsiry', 'Rakotonirina', 'tsiry.rakotonirina9@example.mg', '034 80 263 86', NULL, 'Actif', '2020-01-25', 784983.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 9, 46, 4),
(20, 'Noro', 'Randriambolona', 'noro.randriambolona10@example.mg', '034 73 657 45', NULL, 'Actif', '2022-06-04', 1705316.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 3, 14, 2),
(21, 'Faly', 'Ralaivao', 'faly.ralaivao11@example.mg', '034 19 939 17', NULL, 'Actif', '2024-12-12', 1595339.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 6, 30, 3),
(22, 'Faniry', 'Rasoanaivo', 'faniry.rasoanaivo12@example.mg', '034 64 988 35', NULL, 'Actif', '2019-01-01', 2252699.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 13, 64, 5),
(23, 'Vola', 'Rakotomalala', 'vola.rakotomalala13@example.mg', '034 30 735 29', NULL, 'En Congé', '2019-08-13', 1703197.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 6, 31, 3),
(24, 'Soa', 'Raharimalala', 'soa.raharimalala14@example.mg', '034 75 473 16', NULL, 'Actif', '2021-03-02', 1468032.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 2, 11, 2),
(25, 'Faniry', 'Randriamampionona', 'faniry.randriamampionona15@example.mg', '034 91 724 96', NULL, 'En Congé', '2022-01-09', 527669.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 2, 7, 2),
(26, 'Sitraka', 'Rakotonirina', 'sitraka.rakotonirina16@example.mg', '034 92 414 54', NULL, 'En Congé', '2021-09-03', 838328.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 12, 57, 5),
(27, 'Bakoly', 'Rakotomalala', 'bakoly.rakotomalala17@example.mg', '034 59 521 30', NULL, 'Actif', '2021-05-14', 1225979.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 16, 77, 7),
(28, 'Tahina', 'Randriamampionona', 'tahina.randriamampionona18@example.mg', '034 68 190 88', NULL, 'En Congé', '2024-01-06', 882410.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 7, 35, 3),
(29, 'Voahirana', 'Ramanantsoa', 'voahirana.ramanantsoa19@example.mg', '034 80 403 61', NULL, 'Actif', '2022-06-09', 1697762.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 10, 47, 4),
(30, 'Sitraka', 'Razafindrakoto', 'sitraka.razafindrakoto20@example.mg', '034 74 472 96', NULL, 'Actif', '2019-05-26', 1823018.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 11, 53, 5),
(31, 'Fitiavana', 'Rakotomalala', 'fitiavana.rakotomalala21@example.mg', '034 91 108 87', NULL, 'Actif', '2021-12-25', 759637.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 1, 2, 2),
(32, 'Faniry', 'Razafindrakoto', 'faniry.razafindrakoto22@example.mg', '034 70 368 34', NULL, 'Actif', '2017-11-08', 688580.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 15, 74, 6),
(33, 'Lova', 'Andrianarivo', 'lova.andrianarivo23@example.mg', '034 66 798 45', NULL, 'En Congé', '2018-10-21', 1136991.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 4, 17, 2),
(34, 'Voahirana', 'Rakotonirina', 'voahirana.rakotonirina24@example.mg', '034 28 815 69', NULL, 'Inactif', '2025-03-14', 2263608.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 13, 63, 5),
(35, 'Tiana', 'Randriambolona', 'tiana.randriambolona25@example.mg', '034 29 670 54', NULL, 'Actif', '2020-11-18', 1519498.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 8, 40, 3),
(36, 'Toky', 'Rafalimanana', 'toky.rafalimanana26@example.mg', '034 20 390 84', NULL, 'Actif', '2022-05-21', 1918302.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 16, 1, 7),
(37, 'Fitiavana', 'Ramanantsoa', 'fitiavana.ramanantsoa27@example.mg', '034 62 752 20', NULL, 'Actif', '2024-10-07', 723075.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 16, 77, 7),
(38, 'Niry', 'Rabemananjara', 'niry.rabemananjara28@example.mg', '034 49 775 62', NULL, 'Actif', '2021-01-23', 1021716.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 6, 29, 3),
(39, 'Mamy', 'Randrianarisoa', 'mamy.randrianarisoa29@example.mg', '034 49 960 48', NULL, 'Actif', '2019-08-10', 1821614.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 12, 60, 5),
(40, 'Hoby', 'Raharimalala', 'hoby.raharimalala30@example.mg', '034 90 756 62', NULL, 'Actif', '2024-07-14', 668195.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 6, 27, 3),
(41, 'Tiana', 'Rakotonirina', 'tiana.rakotonirina31@example.mg', '034 20 782 65', NULL, 'Actif', '2019-02-09', 2463482.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 14, 67, 6),
(42, 'Tiana', 'Rasolofomanana', 'tiana.rasolofomanana32@example.mg', '034 24 119 38', NULL, 'En Congé', '2022-04-06', 625085.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 19, 92, 7),
(43, 'Noro', 'Randriambolona', 'noro.randriambolona33@example.mg', '034 74 221 23', NULL, 'Actif', '2021-08-04', 1251281.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 14, 68, 6),
(44, 'Narindra', 'Rakotondrainibe', 'narindra.rakotondrainibe34@example.mg', '034 42 172 77', NULL, 'En Congé', '2018-03-16', 1630714.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 10, 49, 4),
(45, 'Faly', 'Rabemananjara', 'faly.rabemananjara35@example.mg', '034 71 172 66', NULL, 'En Congé', '2025-05-15', 2348274.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 13, 62, 5),
(46, 'Niry', 'Rafalimanana', 'niry.rafalimanana36@example.mg', '034 22 870 25', NULL, 'Actif', '2021-11-12', 1002647.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 17, 82, 7),
(47, 'Onja', 'Randriamampionona', 'onja.randriamampionona37@example.mg', '034 59 206 26', NULL, 'Inactif', '2022-04-11', 2320386.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 6, 29, 3),
(48, 'Niry', 'Ramanantsoa', 'niry.ramanantsoa38@example.mg', '034 27 581 69', NULL, 'Actif', '2020-02-15', 555787.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 1, 2, 2),
(49, 'Bakoly', 'Rabemananjara', 'bakoly.rabemananjara39@example.mg', '034 83 422 65', NULL, 'Actif', '2025-10-22', 1369213.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 5, 23, 3),
(50, 'Bakoly', 'Rakotoarisoa', 'bakoly.rakotoarisoa40@example.mg', '034 31 196 56', NULL, 'Actif', '2018-08-13', 1229763.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 1, 4, 2),
(51, 'Toky', 'Rakotonirina', 'toky.rakotonirina41@example.mg', '034 73 576 64', NULL, 'En Congé', '2021-06-02', 1241877.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 5, 24, 3),
(52, 'Noro', 'Rafalimanana', 'noro.rafalimanana42@example.mg', '034 91 761 31', NULL, 'Actif', '2021-05-13', 951535.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 9, 45, 4),
(53, 'Noro', 'Ratsimbazafy', 'noro.ratsimbazafy43@example.mg', '034 36 849 27', NULL, 'Actif', '2023-07-16', 2251842.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 14, 70, 6),
(54, 'Faly', 'Rabemananjara', 'faly.rabemananjara44@example.mg', '034 10 306 46', NULL, 'En Congé', '2025-02-09', 2300770.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 3, 12, 2),
(55, 'Faniry', 'Rasoanaivo', 'faniry.rasoanaivo45@example.mg', '034 87 788 25', NULL, 'Actif', '2022-04-08', 1756888.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 18, 90, 7),
(56, 'Faly', 'Rafalimanana', 'faly.rafalimanana46@example.mg', '034 92 368 43', NULL, 'En Congé', '2018-03-04', 2480720.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 12, 57, 5),
(57, 'Sitraka', 'Rakotomalala', 'sitraka.rakotomalala47@example.mg', '034 40 179 94', NULL, 'Actif', '2023-02-17', 916683.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 15, 73, 6),
(58, 'Hasina', 'Rabemananjara', 'hasina.rabemananjara48@example.mg', '034 16 765 44', NULL, 'Actif', '2023-04-19', 2043090.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 6, 27, 3),
(59, 'Soa', 'Raharimalala', 'soa.raharimalala49@example.mg', '034 13 585 68', NULL, 'Actif', '2018-12-30', 510134.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 16, 78, 7),
(60, 'Nirina', 'Rakotomamonjy', 'nirina.rakotomamonjy50@example.mg', '034 30 843 42', NULL, 'Actif', '2022-09-27', 503925.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 10, 51, 4),
(61, 'Heriniaina', 'Rakotondrainibe', 'heriniaina.rakotondrainibe51@example.mg', '034 32 606 34', NULL, 'Actif', '2021-11-08', 686936.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 13, 65, 5),
(62, 'Noro', 'Razafindrakoto', 'noro.razafindrakoto52@example.mg', '034 52 799 38', NULL, 'Actif', '2022-02-18', 1157534.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 6, 30, 3),
(63, 'Tsiry', 'Rafalimanana', 'tsiry.rafalimanana53@example.mg', '034 94 505 52', NULL, 'Actif', '2020-01-15', 987534.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 2, 8, 2),
(64, 'Aina', 'Ralaivao', 'aina.ralaivao54@example.mg', '034 90 496 26', NULL, 'En Congé', '2019-03-31', 1151870.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 5, 24, 3),
(65, 'Toky', 'Rafalimanana', 'toky.rafalimanana55@example.mg', '034 35 627 61', NULL, 'Actif', '2017-12-29', 1235561.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 7, 35, 3),
(66, 'Hoby', 'Randriambolona', 'hoby.randriambolona56@example.mg', '034 35 538 37', NULL, 'Actif', '2025-02-27', 1187767.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 9, 44, 4),
(67, 'Sitraka', 'Rafalimanana', 'sitraka.rafalimanana57@example.mg', '034 55 454 44', NULL, 'Actif', '2018-07-31', 458513.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 9, 43, 4),
(68, 'Vola', 'Rakotoarisoa', 'vola.rakotoarisoa58@example.mg', '034 68 201 34', NULL, 'Actif', '2022-08-28', 499931.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 6, 30, 3),
(69, 'Toky', 'Rakotomalala', 'toky.rakotomalala59@example.mg', '034 37 575 89', NULL, 'Actif', '2020-05-03', 2291763.00, NULL, NULL, NULL, '2026-01-03 12:37:19', '2026-01-03 12:37:19', 17, 83, 7);

-- --------------------------------------------------------

--
-- Structure de la table `postes`
--

CREATE TABLE `postes` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `postes`
--

INSERT INTO `postes` (`id`, `name`, `description`, `service_id`, `created_at`, `updated_at`) VALUES
(1, 'stagiaire', 'Poste: stagiaire', 16, '2025-12-16 20:26:23', '2025-12-16 20:26:23'),
(2, 'Chef de Service', 'Responsable du Service de la Mobilité et des Échanges', 1, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(3, 'Assistant(e) de Service', 'Assistance administrative pour le Service de la Mobilité et des Échanges', 1, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(4, 'Agent Administratif', 'Support administratif', 1, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(5, 'Chargé d\'Études', 'Analyse et rapports', 1, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(6, 'Secrétaire', 'Accueil et secrétariat', 1, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(7, 'Chef de Service', 'Responsable du Service de l\'Électrification rurale et de l\'Usage multiple de l\'Eau', 2, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(8, 'Assistant(e) de Service', 'Assistance administrative pour le Service de l\'Électrification rurale et de l\'Usage multiple de l\'Eau', 2, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(9, 'Agent Administratif', 'Support administratif', 2, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(10, 'Chargé d\'Études', 'Analyse et rapports', 2, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(11, 'Secrétaire', 'Accueil et secrétariat', 2, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(12, 'Chef de Service', 'Responsable du Service de la Bonne Gouvernance', 3, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(13, 'Assistant(e) de Service', 'Assistance administrative pour le Service de la Bonne Gouvernance', 3, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(14, 'Agent Administratif', 'Support administratif', 3, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(15, 'Chargé d\'Études', 'Analyse et rapports', 3, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(16, 'Secrétaire', 'Accueil et secrétariat', 3, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(17, 'Chef de Service', 'Responsable du Service de la Protection Civile et des Renseignements', 4, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(18, 'Assistant(e) de Service', 'Assistance administrative pour le Service de la Protection Civile et des Renseignements', 4, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(19, 'Agent Administratif', 'Support administratif', 4, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(20, 'Chargé d\'Études', 'Analyse et rapports', 4, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(21, 'Secrétaire', 'Accueil et secrétariat', 4, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(22, 'Chef de Service', 'Responsable du Service Chargé de la promotion de l\'Agriculture, Elevage, Pêche, Foresterie', 5, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(23, 'Assistant(e) de Service', 'Assistance administrative pour le Service Chargé de la promotion de l\'Agriculture, Elevage, Pêche, Foresterie', 5, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(24, 'Ingénieur Agronome', 'Expertise agricole', 5, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(25, 'Technicien Agricole', 'Support terrain', 5, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(26, 'Vétérinaire', 'Santé animale', 5, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(27, 'Chef de Service', 'Responsable du Service Chargé de la Promotion de l\'Industrie et des Mines', 6, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(28, 'Assistant(e) de Service', 'Assistance administrative pour le Service Chargé de la Promotion de l\'Industrie et des Mines', 6, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(29, 'Agent Administratif', 'Support administratif', 6, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(30, 'Chargé d\'Études', 'Analyse et rapports', 6, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(31, 'Secrétaire', 'Accueil et secrétariat', 6, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(32, 'Chef de Service', 'Responsable du Service Chargé de la promotion du Tourisme', 7, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(33, 'Assistant(e) de Service', 'Assistance administrative pour le Service Chargé de la promotion du Tourisme', 7, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(34, 'Agent Administratif', 'Support administratif', 7, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(35, 'Chargé d\'Études', 'Analyse et rapports', 7, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(36, 'Secrétaire', 'Accueil et secrétariat', 7, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(37, 'Chef de Service', 'Responsable du Service de l\'Intelligence Économique', 8, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(38, 'Assistant(e) de Service', 'Assistance administrative pour le Service de l\'Intelligence Économique', 8, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(39, 'Agent Administratif', 'Support administratif', 8, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(40, 'Chargé d\'Études', 'Analyse et rapports', 8, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(41, 'Secrétaire', 'Accueil et secrétariat', 8, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(42, 'Chef de Service', 'Responsable du Service chargé de la Protection de l\'Environnement', 9, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(43, 'Assistant(e) de Service', 'Assistance administrative pour le Service chargé de la Protection de l\'Environnement', 9, '2026-01-03 11:55:06', '2026-01-03 11:55:06'),
(44, 'Expert Environnemental', 'Études d\'impact', 9, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(45, 'Garde Forestier', 'Surveillance', 9, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(46, 'Technicien Assainissement', 'Gestion des déchets', 9, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(47, 'Chef de Service', 'Responsable du Service de l\'Éducation et du Suivi environnemental', 10, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(48, 'Assistant(e) de Service', 'Assistance administrative pour le Service de l\'Éducation et du Suivi environnemental', 10, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(49, 'Expert Environnemental', 'Études d\'impact', 10, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(50, 'Garde Forestier', 'Surveillance', 10, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(51, 'Technicien Assainissement', 'Gestion des déchets', 10, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(52, 'Chef de Service', 'Responsable du Service de l\'Education et de la Formation', 11, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(53, 'Assistant(e) de Service', 'Assistance administrative pour le Service de l\'Education et de la Formation', 11, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(54, 'Conseiller Pédagogique', 'Support aux enseignants', 11, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(55, 'Planificateur', 'Planification scolaire', 11, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(56, 'Chef de Service', 'Responsable du Service de l\'Amélioration du Cadre de vie', 12, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(57, 'Assistant(e) de Service', 'Assistance administrative pour le Service de l\'Amélioration du Cadre de vie', 12, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(58, 'Agent Administratif', 'Support administratif', 12, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(59, 'Chargé d\'Études', 'Analyse et rapports', 12, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(60, 'Secrétaire', 'Accueil et secrétariat', 12, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(61, 'Chef de Service', 'Responsable du Service de la Protection Sociale', 13, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(62, 'Assistant(e) de Service', 'Assistance administrative pour le Service de la Protection Sociale', 13, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(63, 'Agent Administratif', 'Support administratif', 13, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(64, 'Chargé d\'Études', 'Analyse et rapports', 13, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(65, 'Secrétaire', 'Accueil et secrétariat', 13, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(66, 'Chef de Service', 'Responsable du Service des Études et des Réalisations', 14, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(67, 'Assistant(e) de Service', 'Assistance administrative pour le Service des Études et des Réalisations', 14, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(68, 'Agent Administratif', 'Support administratif', 14, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(69, 'Chargé d\'Études', 'Analyse et rapports', 14, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(70, 'Secrétaire', 'Accueil et secrétariat', 14, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(71, 'Chef de Service', 'Responsable du Service de la Logistique', 15, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(72, 'Assistant(e) de Service', 'Assistance administrative pour le Service de la Logistique', 15, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(73, 'Agent Logistique', 'Gestion des stocks et matériel', 15, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(74, 'Chauffeur', 'Transport', 15, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(75, 'Magasinier', 'Gestion de l\'entrepôt', 15, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(76, 'Chef de Service', 'Responsable du Service des Finances', 16, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(77, 'Assistant(e) de Service', 'Assistance administrative pour le Service des Finances', 16, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(78, 'Comptable', 'Gestion comptable', 16, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(79, 'Agent de Recouvrement', 'Suivi des recettes', 16, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(80, 'Auditeur Interne', 'Contrôle financier', 16, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(81, 'Chef de Service', 'Responsable du Service des Ressources Financières', 17, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(82, 'Assistant(e) de Service', 'Assistance administrative pour le Service des Ressources Financières', 17, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(83, 'Agent Administratif', 'Support administratif', 17, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(84, 'Chargé d\'Études', 'Analyse et rapports', 17, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(85, 'Secrétaire', 'Accueil et secrétariat', 17, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(86, 'Chef de Service', 'Responsable du Service des Ressources Humaines', 18, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(87, 'Assistant(e) de Service', 'Assistance administrative pour le Service des Ressources Humaines', 18, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(88, 'Gestionnaire RH', 'Gestion du personnel', 18, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(89, 'Chargé de Formation', 'Formation et développement', 18, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(90, 'Juriste Droit Social', 'Conseil juridique RH', 18, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(91, 'Chef de Service', 'Responsable du Service de la Comptabilité et de la Logistique', 19, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(92, 'Assistant(e) de Service', 'Assistance administrative pour le Service de la Comptabilité et de la Logistique', 19, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(93, 'Comptable', 'Gestion comptable', 19, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(94, 'Agent de Recouvrement', 'Suivi des recettes', 19, '2026-01-03 11:55:07', '2026-01-03 11:55:07'),
(95, 'Auditeur Interne', 'Contrôle financier', 19, '2026-01-03 11:55:07', '2026-01-03 11:55:07');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `direction_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `name`, `direction_id`) VALUES
(1, 'Service de la Mobilité et des Échanges', 2),
(2, 'Service de l\'Électrification rurale et de l\'Usage multiple de l\'Eau', 2),
(3, 'Service de la Bonne Gouvernance', 2),
(4, 'Service de la Protection Civile et des Renseignements', 2),
(5, 'Service Chargé de la promotion de l\'Agriculture, Elevage, Pêche, Foresterie', 3),
(6, 'Service Chargé de la Promotion de l\'Industrie et des Mines', 3),
(7, 'Service Chargé de la promotion du Tourisme', 3),
(8, 'Service de l\'Intelligence Économique', 3),
(9, 'Service chargé de la Protection de l\'Environnement', 4),
(10, 'Service de l\'Éducation et du Suivi environnemental', 4),
(11, 'Service de l\'Education et de la Formation', 5),
(12, 'Service de l\'Amélioration du Cadre de vie', 5),
(13, 'Service de la Protection Sociale', 5),
(14, 'Service des Études et des Réalisations', 6),
(15, 'Service de la Logistique', 6),
(16, 'Service des Finances', 7),
(17, 'Service des Ressources Financières', 7),
(18, 'Service des Ressources Humaines', 7),
(19, 'Service de la Comptabilité et de la Logistique', 7),
(21, 'service de Permis de conduire', 9);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'altobruni', '$2y$10$JtFCqWKkB4ZXNNY.mF7Wv.0PlVTsodgtK2omJ3q1yg4neN2gJNLrC', '2025-12-16 19:20:01');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `directions`
--
ALTER TABLE `directions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_service` (`service_id`),
  ADD KEY `idx_direction` (`direction_id`),
  ADD KEY `poste_id` (`poste_id`);

--
-- Index pour la table `postes`
--
ALTER TABLE `postes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_poste_per_service` (`name`,`service_id`),
  ADD KEY `idx_service` (`service_id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `direction_id` (`direction_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `directions`
--
ALTER TABLE `directions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT pour la table `postes`
--
ALTER TABLE `postes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD CONSTRAINT `personnel_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `personnel_ibfk_2` FOREIGN KEY (`direction_id`) REFERENCES `directions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `personnel_ibfk_3` FOREIGN KEY (`poste_id`) REFERENCES `postes` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `postes`
--
ALTER TABLE `postes`
  ADD CONSTRAINT `postes_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`direction_id`) REFERENCES `directions` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
