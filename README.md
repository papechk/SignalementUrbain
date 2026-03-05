# Signalement Urbain - Application de Gestion des Incidents

## Description

Application web Laravel destinée aux mairies pour la gestion et le suivi des signalements de problèmes urbains. Les citoyens peuvent signaler des incidents (voirie, éclairage, propreté, etc.) et la mairie assure le suivi et le traitement.

## Fonctionnalités

### Pour les citoyens
- **Créer un signalement** avec titre, description, catégorie, adresse, photo
- **Suivre** l'état de son signalement via la référence unique (SIG-XXXXXXXX)
- **Consulter** la liste de tous les signalements

### Pour la mairie (agent/admin)
- **Tableau de bord** avec statistiques en temps réel
  - Total, nouveaux, en cours, résolus
  - Taux de résolution
  - Répartition par catégorie et priorité
  - Alertes sur les signalements urgents
- **Gérer les signalements** : CRUD complet (Create, Read, Update, Delete)
- **Changer le statut** rapidement : Nouveau → En cours → Résolu / Rejeté
- **Commenter** les signalements (réponse de la mairie)
- **Filtrer et rechercher** par statut, priorité, catégorie, mot-clé
- **Gérer les catégories** de signalement

## Prérequis

- PHP >= 8.1
- Composer
- MySQL ou MariaDB
- Node.js (optionnel, pour les assets)

## Installation

```bash
# 1. Cloner le projet
git clone <url-du-repo> signalement-urbain
cd signalement-urbain

# 2. Installer les dépendances
composer install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données dans .env
# DB_DATABASE=signalement_urbain
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Créer la base de données
mysql -u root -e "CREATE DATABASE signalement_urbain;"

# 6. Lancer les migrations
php artisan migrate

# 7. Peupler avec les données de démonstration
php artisan db:seed

# 8. Lancer le serveur
php artisan serve
```

Accédez à l'application : **http://localhost:8000**

## Structure du Projet

```
signalement-urbain/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── SignalementController.php   # CRUD signalements
│   │       ├── CategorieController.php     # CRUD catégories
│   │       └── DashboardController.php     # Tableau de bord
│   └── Models/
│       ├── Signalement.php                 # Modèle signalement
│       ├── Categorie.php                   # Modèle catégorie
│       └── User.php                        # Modèle utilisateur
├── database/
│   ├── migrations/                         # Structure BDD
│   └── seeders/
│       └── DatabaseSeeder.php              # Données de test
├── resources/views/
│   ├── layouts/app.blade.php               # Template principal
│   ├── dashboard/index.blade.php           # Tableau de bord
│   ├── signalements/
│   │   ├── index.blade.php                 # Liste
│   │   ├── create.blade.php                # Création
│   │   ├── show.blade.php                  # Détails
│   │   └── edit.blade.php                  # Modification
│   └── categories/
│       ├── index.blade.php                 # Liste
│       ├── create.blade.php                # Création
│       └── edit.blade.php                  # Modification
├── routes/web.php                          # Routes
├── docs/DIAGRAMMES.md                      # Diagrammes UML
└── public/uploads/                         # Photos uploadées
```

## Statuts d'un signalement

| Statut    | Badge   | Description                        |
|-----------|---------|-------------------------------------|
| Nouveau   | Bleu    | Vient d'être créé                  |
| En cours  | Orange  | Pris en charge par la mairie       |
| Résolu    | Vert    | Problème corrigé                   |
| Rejeté    | Rouge   | Non valide ou doublon              |

## Niveaux de priorité

| Priorité  | Badge   | Description                        |
|-----------|---------|-------------------------------------|
| Faible    | Cyan    | Peut attendre                      |
| Moyenne   | Bleu    | Traitement normal                  |
| Haute     | Orange  | Traitement prioritaire             |
| Urgente   | Rouge   | Intervention immédiate requise     |

## Catégories par défaut

1. Voirie
2. Éclairage public
3. Propreté
4. Espaces verts
5. Signalisation
6. Eau & Assainissement
7. Nuisances sonores
8. Stationnement
9. Bâtiments publics
10. Autre

## Comptes de démonstration

| Rôle  | Email            | Mot de passe |
|-------|------------------|-------------|
| Admin | admin@mairie.fr  | password    |
| Agent | agent@mairie.fr  | password    |

## Technologies

- **Backend** : Laravel (PHP 8.1+)
- **Frontend** : Bootstrap 5.3 + Bootstrap Icons
- **Base de données** : MySQL / MariaDB
- **ORM** : Eloquent
- **Template** : Blade

## Licence

Application développée pour la gestion municipale des signalements urbains.
