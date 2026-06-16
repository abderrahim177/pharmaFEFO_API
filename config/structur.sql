CREATE DATABASE pharmaFEFO_API;
use pharmaFEFO_API;
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('Preparateur', 'Pharmacien', 'Administrateur') NOT NULL
);