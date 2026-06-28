

CREATE DATABASE IF NOT EXISTS ecole_formation 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE ecole_formation;


CREATE TABLE IF NOT EXISTS utilisateurs (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom_complet VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS stagiaires (
    id_stagiaire INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telephone VARCHAR(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS formations (
    id_formation INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    duree VARCHAR(50) NOT NULL,
    prix DECIMAL(10, 2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS inscriptions (
    id_inscription INT AUTO_INCREMENT PRIMARY KEY,
    id_stagiaire INT,
    id_formation INT,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_stagiaire) REFERENCES stagiaires(id_stagiaire) ON DELETE CASCADE,
    FOREIGN KEY (id_formation) REFERENCES formations(id_formation) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO utilisateurs (nom_complet, email, mot_de_passe) 
VALUES (
    'Directeur', 
    'admis@ecole.com', 
    '123'
) ON DUPLICATE KEY UPDATE id_user=id_user;