-- ============================================================
--  StaffManager — Base de données
--  À importer dans phpMyAdmin ou via MySQL en ligne de commande
-- ============================================================

CREATE DATABASE IF NOT EXISTS staffmanager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE staffmanager;

-- ============================================================
--  TABLE : utilisateurs
--  Gère la connexion et les rôles (admin, rh, employe)
-- ============================================================
CREATE TABLE IF NOT EXISTS utilisateurs (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nom             VARCHAR(100)    NOT NULL,
    email           VARCHAR(150)    NOT NULL UNIQUE,
    mot_de_passe    VARCHAR(255)    NOT NULL,
    role            ENUM('admin', 'rh', 'employe') NOT NULL DEFAULT 'employe',
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
--  TABLE : departements
-- ============================================================
CREATE TABLE IF NOT EXISTS departements (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100) NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
--  TABLE : postes
--  Chaque poste est rattaché à un département
-- ============================================================
CREATE TABLE IF NOT EXISTS postes (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    titre           VARCHAR(100) NOT NULL,
    departement_id  INT NOT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (departement_id) REFERENCES departements(id) ON DELETE CASCADE
);

-- ============================================================
--  TABLE : employes
-- ============================================================
CREATE TABLE IF NOT EXISTS employes (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nom             VARCHAR(100)        NOT NULL,
    prenom          VARCHAR(100)        NOT NULL,
    email           VARCHAR(150)        NOT NULL UNIQUE,
    telephone       VARCHAR(20),
    salaire         DECIMAL(10, 2)      NOT NULL DEFAULT 0.00,
    date_embauche   DATE                NOT NULL,
    poste_id        INT,
    departement_id  INT,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (poste_id)       REFERENCES postes(id)       ON DELETE SET NULL,
    FOREIGN KEY (departement_id) REFERENCES departements(id) ON DELETE SET NULL
);

-- ============================================================
--  TABLE : conges
-- ============================================================
CREATE TABLE IF NOT EXISTS conges (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    employe_id  INT NOT NULL,
    date_debut  DATE NOT NULL,
    date_fin    DATE NOT NULL,
    motif       TEXT,
    statut      ENUM('en_attente', 'approuve', 'refuse') NOT NULL DEFAULT 'en_attente',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employe_id) REFERENCES employes(id) ON DELETE CASCADE
);

-- ============================================================
--  DONNÉES DE TEST
-- ============================================================

-- Départements
INSERT INTO departements (nom) VALUES
    ('Ressources Humaines'),
    ('Informatique'),
    ('Comptabilité'),
    ('Marketing'),
    ('Direction');

-- Postes
INSERT INTO postes (titre, departement_id) VALUES
    ('Responsable RH',          1),
    ('Chargé de recrutement',   1),
    ('Développeur Web',         2),
    ('Administrateur Réseau',   2),
    ('Chef de projet IT',       2),
    ('Comptable',               3),
    ('Auditeur',                3),
    ('Responsable Marketing',   4),
    ('Chargé de communication', 4),
    ('Directeur Général',       5),
    ('Directeur Adjoint',       5);

-- Utilisateurs
-- Les mots de passe sont hashés avec password_hash() en PHP
-- Mot de passe pour tous les comptes de test : "password123"
-- Hash généré avec : password_hash("password123", PASSWORD_DEFAULT)
INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES
    ('Administrateur',  'admin@staffmanager.com',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
    ('Martin Sophie',   'sophie.martin@staff.com',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'rh'),
    ('Dupont Jean',     'jean.dupont@staff.com',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
    ('Kamga Paul',      'paul.kamga@staff.com',     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
    ('Ngono Claire',    'claire.ngono@staff.com',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe');

-- Employés
INSERT INTO employes (nom, prenom, email, telephone, salaire, date_embauche, poste_id, departement_id) VALUES
    ('Martin',  'Sophie',   'sophie.martin@staff.com',  '0612345678',   3500.00,    '2020-03-15',   1,  1),
    ('Dupont',  'Jean',     'jean.dupont@staff.com',    '0623456789',   2800.00,    '2021-06-01',   3,  2),
    ('Kamga',   'Paul',     'paul.kamga@staff.com',     '0634567890',   3100.00,    '2019-11-20',   4,  2),
    ('Ngono',   'Claire',   'claire.ngono@staff.com',   '0645678901',   2600.00,    '2022-01-10',   6,  3),
    ('Foko',    'Alain',    'alain.foko@staff.com',     '0656789012',   2900.00,    '2021-09-05',   8,  4),
    ('Bello',   'Aminata',  'aminata.bello@staff.com',  '0667890123',   3200.00,    '2020-07-22',   5,  2),
    ('Tagne',   'Eric',     'eric.tagne@staff.com',     '0678901234',   2750.00,    '2023-02-14',   9,  4),
    ('Mballa',  'Diane',    'diane.mballa@staff.com',   '0689012345',   2650.00,    '2022-08-30',   7,  3),
    ('Nkoa',    'Boris',    'boris.nkoa@staff.com',     '0690123456',   2500.00,    '2023-05-18',   2,  1),
    ('Etoga',   'Lucie',    'lucie.etoga@staff.com',    '0601234567',   5000.00,    '2018-01-02',   10, 5);

-- Congés
INSERT INTO conges (employe_id, date_debut, date_fin, motif, statut) VALUES
    (1, '2024-07-01', '2024-07-15',    'Congés annuels',           'approuve'),
    (2, '2024-08-05', '2024-08-20',    'Vacances en famille',      'approuve'),
    (3, '2024-09-10', '2024-09-14',    'Raisons personnelles',     'refuse'),
    (4, '2024-10-01', '2024-10-05',    'Congé maladie',            'approuve'),
    (5, '2025-01-15', '2025-01-22',    'Congés annuels',           'en_attente'),
    (6, '2025-02-03', '2025-02-07',    'Formation externe',        'en_attente'),
    (7, '2025-03-10', '2025-03-20',    'Congés annuels',           'en_attente'),
    (2, '2025-04-01', '2025-04-05',    'Raisons familiales',       'en_attente');
