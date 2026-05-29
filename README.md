# 🧑‍💼 StaffManager
> Application Web de gestion du personnel d'une entreprise
> Développée en **PHP · XML · AJAX** — Projet scolaire Keyce Informatique

---

## 📌 Table des matières

- [Présentation](#-présentation)
- [Stack technique](#-stack-technique)
- [Prérequis & Installation](#-prérequis--installation)
- [Comptes de test](#-comptes-de-test)
- [Fonctionnalités](#-fonctionnalités)
- [Structure du projet](#-structure-du-projet)
- [Base de données](#-base-de-données)
- [Répartition des tâches](#-répartition-des-tâches)
- [Règles Git](#-règles-git)
- [Planning](#-planning)

---

## 📖 Présentation

**StaffManager** est une application web locale permettant de gérer le personnel d'une entreprise. Elle couvre la gestion des employés, des départements, des postes et des congés, avec un tableau de bord dynamique et un système d'export XML.

---

## 🛠 Stack technique

| Technologie | Utilisation |
|---|---|
| **PHP 8+** | Logique serveur, CRUD, sessions, PDO |
| **MySQL** | Base de données relationnelle |
| **XML / XSD** | Export des données, configuration de l'app, validation de structure |
| **AJAX (Fetch API)** | Recherche dynamique, filtres, stats, validation des congés |
| **HTML5 / CSS3** | Interface utilisateur |
| **Git / GitHub** | Versioning et collaboration |

---

## 💻 Prérequis & Installation

### Outils nécessaires

| Outil | Lien | Note |
|---|---|---|
| XAMPP (Linux) ou WAMP (Windows) | [xampp.org](https://www.apachefriends.org) | Fournit Apache + MySQL + PHP |
| Visual Studio Code | [code.visualstudio.com](https://code.visualstudio.com) | Éditeur recommandé |
| Git | [git-scm.com](https://git-scm.com) | Gestion des versions |

---

### Installation — Linux (Kali / Ubuntu)

```bash
# 1. Démarrer XAMPP
sudo /opt/lampp/lampp start

# 2. Cloner le repo dans le dossier web
cd /opt/lampp/htdocs
sudo git clone https://github.com/STRICZ-613/staffmanager.git
sudo chown -R $USER:$USER staffmanager
cd staffmanager

# 3. Aller sur la bonne branche
git checkout develop

# 4. Importer la base de données
sudo /opt/lampp/bin/mysql -u root < database.sql

# 5. Accéder à l'application
# Ouvrir le navigateur sur : http://localhost/staffmanager/auth/login.php
```

---

### Installation — Windows (WAMP)

```bash
# 1. Démarrer WAMP (icône dans la barre des tâches → tout doit être en vert)

# 2. Cloner le repo dans le dossier web
# Ouvrir Git Bash et taper :
cd C:/wamp64/www
git clone https://github.com/STRICZ-613/staffmanager.git
cd staffmanager

# 3. Aller sur sa branche
git checkout feature/ta-branche

# 4. Importer la base de données
# Ouvrir phpMyAdmin : http://localhost/phpmyadmin
# Cliquer sur "Importer" → Choisir database.sql → Exécuter

# 5. Accéder à l'application
# Ouvrir le navigateur sur : http://localhost/staffmanager/auth/login.php
```

---

### ⚠️ Note importante sur `config/db.php`

Le fichier `config/db.php` est dans le `.gitignore` car il contient les identifiants de connexion à la base de données.

**Sur Linux (XAMPP)** — le mot de passe MySQL est vide par défaut :
```xml
<password></password>
```

**Sur Windows (WAMP)** — le mot de passe MySQL est aussi vide par défaut. Si tu en as défini un, modifie `config/config.xml` :
```xml
<password>ton_mot_de_passe</password>
```

---

## 🔑 Comptes de test

| Email | Mot de passe | Rôle |
|---|---|---|
| `admin@staffmanager.com` | `password` | Admin |
| `sophie.martin@staff.com` | `password` | RH |
| `jean.dupont@staff.com` | `password` | Employé |
| `paul.kamga@staff.com` | `password` | Employé |
| `claire.ngono@staff.com` | `password` | Employé |

---

## ✅ Fonctionnalités

### 🔐 Authentification
- Connexion / Déconnexion sécurisée
- Système de rôles : **Admin**, **RH**, **Employé**
- Chaque rôle voit uniquement ce qu'il a le droit de voir
- Protection de toutes les pages (redirection si non connecté)

### 👤 Gestion des Employés
- Ajouter, modifier, supprimer un employé
- Voir la fiche détaillée d'un employé
- Lister tous les employés dans un tableau
- Recherche en temps réel par nom/prénom **(AJAX)**
- Filtrage de la liste par département **(AJAX)**

### 🏢 Gestion des Départements
- CRUD complet des départements
- Affichage du nombre d'employés par département

### 💼 Gestion des Postes
- CRUD complet des postes (rattachés à un département)
- Chargement dynamique des postes selon le département sélectionné **(AJAX)**

### 📅 Gestion des Congés
- Dépôt d'une demande de congé (date début, date fin, motif)
- Validation / Refus par RH ou Admin **(AJAX, sans rechargement)**
- Historique des congés (tous pour Admin/RH, les siens pour Employé)
- Statuts : **En attente** / **Approuvé** / **Refusé**

### 📊 Tableau de Bord
- Nombre total d'employés
- Nombre de départements
- Nombre de congés en attente
- Chiffres chargés dynamiquement **(AJAX)**

### 📁 XML
- Export de la liste des employés en fichier XML téléchargeable
- Fichier `config.xml` pour les paramètres globaux de l'app
- Fichier `schema.xsd` pour valider la structure du XML exporté

---

## 📁 Structure du projet

```
staffmanager/
│
├── index.php                   # Dashboard principal
├── database.sql                # Script SQL (importer dans phpMyAdmin)
├── README.md                   # Ce fichier
│
├── config/
│   ├── db.php                  # Connexion PDO (⚠️ ignoré par Git)
│   └── config.xml              # Configuration globale de l'app (XML)
│
├── xml/
│   └── schema.xsd              # Schéma de validation XML
│
├── includes/
│   ├── header.php
│   ├── footer.php
│   ├── navbar.php
│   └── session_check.php
│
├── auth/
│   ├── login.php
│   └── logout.php
│
├── employes/
│   ├── liste.php
│   ├── ajouter.php
│   ├── modifier.php
│   ├── supprimer.php
│   └── fiche.php
│
├── departements/
│   ├── liste.php
│   ├── ajouter.php
│   ├── modifier.php
│   └── supprimer.php
│
├── postes/
│   ├── liste.php
│   ├── ajouter.php
│   ├── modifier.php
│   └── supprimer.php
│
├── conges/
│   ├── liste.php
│   ├── demande.php
│   └── validation.php
│
├── rapports/
│   └── export_xml.php
│
├── ajax/
│   ├── recherche_employe.php
│   ├── filtre_departement.php
│   ├── get_postes.php
│   ├── valider_conge.php
│   └── get_stats.php
│
└── assets/
    ├── css/
    │   └── style.css           # ⚠️ Fichier CSS unique — Membre 5 uniquement
    └── js/
        ├── ajax.js
        └── validation.js
```

---

## 🗃️ Base de données

**Nom de la BDD :** `staffmanager`

| Table | Colonnes principales |
|---|---|
| `utilisateurs` | id, nom, email, mot_de_passe, role |
| `departements` | id, nom |
| `postes` | id, titre, departement_id |
| `employes` | id, nom, prenom, email, telephone, salaire, date_embauche, poste_id, departement_id |
| `conges` | id, employe_id, date_debut, date_fin, motif, statut |

---

## 👥 Répartition des tâches

| Membre | Rôle | Fichiers principaux |
|---|---|---|
| **Membre 1** | Chef de projet · Auth · Structure | `database.sql`, `config/`, `includes/`, `auth/`, `index.php` |
| **Membre 2** | Gestion des Employés | `employes/*.php` |
| **Membre 3** | AJAX & Interactivité | `ajax/*.php`, `assets/js/ajax.js`, `assets/js/validation.js` |
| **Membre 4** | Départements · Postes · Congés | `departements/`, `postes/`, `conges/` |
| **Membre 5** | CSS complet · XML | `assets/css/style.css`, `rapports/export_xml.php`, `xml/schema.xsd` |

> ⚠️ **`style.css` est la propriété exclusive de Membre 5.** Les autres membres n'y écrivent aucune ligne de CSS.

---

## 🌿 Règles Git

### Branches

```
main              ← version finale stable — on n'y touche pas avant la fin
develop           ← branche d'intégration — les PR arrivent ici
feature/auth-structure
feature/employes
feature/ajax
feature/dept-postes-conges
feature/css-xml
```

### Workflow de chaque membre

```bash
# Travailler sur sa branche
git checkout feature/ma-branche

# Récupérer les dernières mises à jour de develop avant de commencer
git pull origin develop

# Travailler, puis commiter
git add .
git commit -m "feat: description claire de ce qui a été fait"
git push origin feature/ma-branche

# Ouvrir une Pull Request vers develop sur GitHub
# → Membre 1 valide et merge
```

### Conventions de commit

| Préfixe | Usage |
|---|---|
| `feat:` | Ajout d'une nouvelle fonctionnalité |
| `fix:` | Correction d'un bug |
| `style:` | Modifications CSS uniquement |
| `refactor:` | Refactorisation du code |
| `docs:` | Modification de la documentation |

### Règles importantes

- Commiter **au minimum 2 fois par jour**
- **Ne jamais merger sa propre PR** — c'est Membre 1 qui valide
- **Ne jamais push directement sur `develop` ou `main`**
- Toujours **pull depuis develop** avant de commencer à travailler

---

## 🗓️ Planning

### Jour 1 — Mise en place
| Membre | Objectif |
|---|---|
| 1 | ✅ Repo GitHub, `database.sql`, `db.php`, Auth, `includes/` |
| 2 | `liste.php` + `ajouter.php` employés (structure HTML) |
| 3 | Structure de tous les fichiers `ajax/*.php` + `ajax.js` |
| 4 | CRUD Départements + CRUD Postes |
| 5 | Palette CSS définie + styles de base + `config.xml` |

### Jour 2 — Développement
| Membre | Objectif |
|---|---|
| 1 | Intégration des modules, tests auth |
| 2 | `modifier.php` + `supprimer.php` + `fiche.php` |
| 3 | Brancher tous les scripts AJAX sur les pages des autres |
| 4 | Module congés complet |
| 5 | Styliser toutes les pages + `export_xml.php` + `schema.xsd` |

### Jour 3 — Finitions & Tests
| Membre | Objectif |
|---|---|
| 1 | Merger toutes les PR, résoudre les conflits |
| 2 | Corriger les bugs CRUD |
| 3 | Tester tous les appels AJAX |
| 4 | Tester les congés pour chaque rôle |
| 5 | Retouches CSS + test export XML |

---

*Projet réalisé dans le cadre du cours de développement Web — Keyce Informatique, Yaoundé*
