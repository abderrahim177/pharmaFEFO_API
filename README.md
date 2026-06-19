# pharmaFEFO_API

💊 PharmaFEFO - Gestion Intelligente de Stock Pharmaceutique (FEFO)
PharmaFEFO est une application web moderne de gestion de stock pour officines, axée sur la règle de gestion FEFO (First Expired, First Out). Cette version marque la transition d'un site web classique vers une architecture web asynchrone, sécurisée et découplée, optimisant l'expérience utilisateur et la sécurité des données sensibles.

🚀 Fonctionnalités Clés & Épics (Version Asynchrone)
📦 Épic 1 : Réception & Entrées Intelligentes
US 1.1 (Préparateur) : Soumission asynchrone (Fetch API) des nouveaux lots. Ajout en stock instantané sans rechargement de page.

🛡️ Épic 2 : Surveillance & Alertes Péremption
US 2.1 (Pharmacien Titulaire) : Filtrage dynamique au clic ("Tout", "Alerte Rouge") via la consommation d'un endpoint API dédié (/api/v1/batches?criteria=critical).

US 2.2 (Pharmacien Titulaire) : Compteur dynamique en temps réel affichant les produits arrivant à péremption le mois suivant dès la connexion.

⚡ Épic 3 : Sorties de Stock (Le Cœur FEFO)
US 3.1 (Préparateur) : Décrémentation asynchrone en tâche de fond (POST/PATCH vers /api/v1/batches/checkout) lors de la délivrance d'une boîte, appliquant automatiquement la logique FEFO.

📊 Épic 4 : Gestion des Pertes & Administration
US 4.1 (Pharmacien Titulaire) : Passage instantané d'un lot obsolète au statut Status::EXPIRED avec mise à jour du DOM.

US 4.2 (Administrateur) : Route exclusive /admin/reports pour le suivi financier des pertes (strictement interdite aux autres rôles).

📂 Architecture Logique du Projet
Le projet applique une séparation stricte entre les routes traditionnelles (rendu HTML) et les routes asynchrones (API JSON) :

Plaintext
pharmafefo/
├── config/
│   ├── database.php            # Connexion PDO centralisée
│   └── environment.php         # Gestion dynamique (Local vs Production)
├── public/
│   ├── css/                    # Styles de l'application
│   ├── js/
│   │   ├── app.js              # Logique globale (Sécurité, Sessions, Auth)
│   │   └── dashboard.js        # Moteur Fetch API & manipulation du DOM
│   └── index.php               # Routeur Unique (Aiguillage Web / API)
├── src/
│   ├── Controller/
│   │   ├── Web/                # Contrôleurs Traditionnels (Rendu HTML)
│   │   │   ├── AuthController.php
│   │   │   └── AdminController.php
│   │   └── Api/                # Contrôleurs API (Sortie JSON uniquement)
│   │       ├── ApiDashboardController.php
│   │       └── ApiStockController.php
│   ├── Entity/                 # Modèles de données
│   ├── Enum/                   # Enums (ex: Status::EXPIRED, Rôles)
│   ├── Service/                # Logique Métier isolée
│   │   ├── AuthService.php     # Vérification stricte des sessions/rôles
│   │   └── StockService.php    # Algorithme métier (Calculs & Règle FEFO)
│   └── Repository/             # Requêtes SQL pures (PDO)
└── templates/                  # Squelettes HTML initiaux
🔒 Sécurité & Spécifications Techniques
Contrôle d'Accès Strict (RBAC) : Les rôles (ADMINISTRATEUR, PHARMACIEN, PREPARATEUR) sont vérifiés côté serveur par le AuthService.php avant chaque exécution de route.

Format des Échanges : Interception des formulaires via Event.preventDefault() en JavaScript, transmission en application/json et réponses normalisées côté PHP :

JSON
{
  "success": true,
  "message": "Collaborateur enregistré avec succès !"
}
Nettoyage des Données : Protection contre les failles XSS et injections SQL grâce à strip_tags() et la préparation systématique des requêtes PDO.

🛠️ DevOps & Déploiement
L'application est conçue pour respecter les bonnes pratiques du déploiement continu (CD).

1. Gestion des Secrets
⚠️ Règle absolue : Zéro mot de passe sur GitHub. Le fichier .env contenant les identifiants de production est listé dans le .gitignore. Un fichier .env.example est fourni pour la configuration locale.

2. Environnements Miroirs (config/environment.php)
L'application adapte automatiquement son comportement selon l'environnement :

Développement (local) : Affichage complet et détaillé des erreurs SQL/PHP pour faciliter le débogage.

Production (prod) : Masquage des erreurs sensibles. Affichage d'un message générique standardisé en cas d'erreur 500 afin de sécuriser l'infrastructure.

3. Déploiement Continu (CD)
Le dépôt est configuré pour un déploiement automatisé (via Render ou Railway) branché sur la branche main. Toute Pull Request (PR) validée et fusionnée déclenche automatiquement le build de production.

⚙️ Installation en Local
Cloner le projet :

Bash
git clone https://github.com/votre-username/pharmafefo.git
cd pharmafefo
Configurer l'environnement :

Copier le fichier .env.example et le nommer .env.

Adapter les variables de connexion à votre base de données locale.

Base de données :

Importer le fichier config/structur.sql dans votre gestionnaire de base de données (XAMPP/MySQL).

Lancer le serveur :

Configurer le DocumentRoot de votre serveur local sur le dossier public/.

👥 Équipe & Référentiel
Référentiel : [2023] Développeur web et web mobile

Développeur : Youssef Alami (Super Administrateur / Full-Stack Developer)