CREATE DATABASE IF NOT EXISTS `ecosmart_lab` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ecosmart_lab`;

-- Table des Themes & Filieres Ingenieur
CREATE TABLE `thematiques` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(50) NOT NULL UNIQUE,
    `nom` VARCHAR(150) NOT NULL,
    `description` TEXT,
    `icone` VARCHAR(50) DEFAULT 'bi-cpu',
    `couleur` VARCHAR(30) DEFAULT '#0d6efd',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion des thematiques phares
INSERT INTO `thematiques` (`code`, `nom`, `description`, `icone`, `couleur`) VALUES
('ENERGIE', 'Energie & Developpement Durable', 'Solutions solaires, reseaux intelligents (Smart Grids), hydrogene vert et optimisation energetique.', 'bi-lightning-charge', '#20c997'),
('INFO_IA', 'Systemes dInformation & IA', 'Intelligence artificielle, Machine Learning, Big Data, Cloud Computing et Cybersecurite.', 'bi-cpu', '#0d6efd'),
('ROBOTIQUE', 'Robotique & Systemes Embarques', 'Drones autonomes, bras robotiques, IoT industriel, microcontroleurs STM32 et Arduino.', 'bi-robot', '#fd7e14'),
('MOBILITE', 'Mobilite Electrique & Smart Cities', 'Vehicules electriques, bornes intelligentes, capteurs urbains et gestion du trafic.', 'bi-ev-front', '#6f42c1'),
('GENIE_INDUS', 'Genie Industriel & 4.0', 'Automatisation industrielle, jumeaux numeriques, logistique connectee et lean manufacturing.', 'bi-gear-wide-connected', '#d63384');

-- 4. Table principale : Inscriptions et Soumissions de Projets
CREATE TABLE `projets_inscriptions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(100) NOT NULL,
    `prenom` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `telephone` VARCHAR(30) NOT NULL,
    `niveau_etudes` VARCHAR(50) NOT NULL, -- Ex: '1AE', '2AE', '3AE', '4AE', '5AE', 'Enseignant', 'Partenaire'
    `filiere` VARCHAR(150) NOT NULL,      -- Filiere dingenierie
    `titre_projet` VARCHAR(200) NOT NULL,
    `type_projet` VARCHAR(80) NOT NULL,   -- Ex: 'R&D', 'Projet Semestriel', 'Hackathon / Associatif', 'Prototype Industriel'
    `domaines_cles` TEXT NOT NULL,        -- Liste des domaines selectionnes (JSON ou texte separe par virgules)
    `budget_estime` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `date_debut` DATE NOT NULL,
    `duree_semaines` INT NOT NULL DEFAULT 4,
    `besoin_laboratoire` VARCHAR(10) NOT NULL DEFAULT 'Non', -- 'Oui' ou 'Non'
    `description` TEXT NOT NULL,
    `statut` ENUM('En attente', 'Valide', 'En cours', 'Termine', 'Rejete') DEFAULT 'En attente',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO `projets_inscriptions` 
(`nom`, `prenom`, `email`, `telephone`, `niveau_etudes`, `filiere`, `titre_projet`, `type_projet`, `domaines_cles`, `budget_estime`, `date_debut`, `duree_semaines`, `besoin_laboratoire`, `description`, `statut`, `created_at`) 
VALUES
('REZIG', 'Fadi', 'fadi.rezig@epmi-edu.fr', '+33 6 12 34 56 78', '1AE', 'Energie & Developpement Durable', 'Micro-Reseau Solaire Autonome pour Campus', 'Projet Semestriel', 'Energies Renouvelables, IoT & Capteurs, Efficacite Energetique', 1500.00, '2026-10-01', 8, 'Oui', 'Developpement et banc de test d un micro-reseau photovoltaique intelligent avec stockage batterie Li-ion et pilotage par microcontroleur ESP32.', 'Valide', '2026-09-10 10:15:00'),

('alice', 'bob', 'alice.bob@epmi-edu.fr', '+33 7 98 76 54 32', '1AE', 'Systemes dInformation & IA', 'Detection Predictive des Pannes Electriques par Machine Learning', 'R&D', 'Intelligence Artificielle, Big Data & Cloud, Cybersecurite', 2800.00, '2026-10-15', 12, 'Non', 'Algorithme d analyse des series temporelles de tension et courant pour predire les defaillances des transformateurs haute tension.', 'En cours', '2026-10-11 14:30:00'),

('Camelaye', 'Damien', 'damien.camelaye@epmi-edu.fr', '+33 6 45 67 89 01', '2AE', 'Robotique & Systemes Embarques', 'Robot Rover d Inspection de Canalisations Souterraines', 'Prototype Industriel', 'Robotique & Drones, IoT & Capteurs, Systemes Embarques', 3400.00, '2026-11-01', 16, 'Oui', 'Conception mecanique 3D et electronique d un robot tout-terrain chenille equipe d une camera thermique et capteurs de gaz methane.', 'Valide', '2026-09-12 09:00:00'),

('Nzengue', 'Oral', 'camille.lefebvre@epmi-edu.fr', '+33 6 88 11 22 33', '1AE', 'Mobilite Electrique & Smart Cities', 'Borne de Recharge Solaire Bidirectionnelle (V2G)', 'R&D', 'Energies Renouvelables, Smart City & Mobilite, Efficacite Energetique', 4200.00, '2026-10-20', 10, 'Oui', 'Etude et modelisation du protocole Vehicle-to-Grid pour reinjecter le surplus energetique de batteries automobiles dans le reseau local du campus.', 'En attente', '2026-010-13 16:45:00'),

('konhu', 'Drubea', 'drubea.konhu@epmi-edu.fr', '+33 7 22 33 44 55', '3AE', 'Genie Industriel & 4.0', 'Jumeau Numerique d une Chaine de Production Automatisee', 'Hackathon / Associatif', 'Systemes Embarques, Big Data & Cloud, Automatisation', 1200.00, '2026-10-05', 6, 'Non', 'Creation d un modele 3D interactif temps reel sous Unity connecte via protocole MQTT aux automates de l atelier genie industriel.', 'Termine', '2026-10-08 11:20:00');

