# Diagrammes de l'Application - Signalement Urbain

## 1. Diagramme de Cas d'Utilisation (Use Case)

```
┌─────────────────────────────────────────────────────────────────────┐
│                    SYSTÈME DE SIGNALEMENT URBAIN                     │
│                                                                      │
│  ┌──────────────────────┐    ┌──────────────────────┐                │
│  │  Créer un signalement │    │  Consulter le        │                │
│  │                       │    │  tableau de bord     │                │
│  └──────────┬───────────┘    └──────────┬───────────┘                │
│             │                           │                             │
│  ┌──────────┴───────────┐    ┌──────────┴───────────┐                │
│  │  Joindre une photo   │    │  Filtrer les         │                │
│  │                       │    │  signalements        │                │
│  └──────────────────────┘    └──────────────────────┘                │
│                                                                      │
│  ┌──────────────────────┐    ┌──────────────────────┐                │
│  │  Consulter un         │    │  Modifier un         │                │
│  │  signalement          │    │  signalement         │                │
│  └──────────────────────┘    └──────────────────────┘                │
│                                                                      │
│  ┌──────────────────────┐    ┌──────────────────────┐                │
│  │  Changer le statut   │    │  Supprimer un        │                │
│  │  (traitement mairie) │    │  signalement         │                │
│  └──────────────────────┘    └──────────────────────┘                │
│                                                                      │
│  ┌──────────────────────┐    ┌──────────────────────┐                │
│  │  Gérer les catégories│    │  Rechercher un       │                │
│  │  (CRUD)              │    │  signalement         │                │
│  └──────────────────────┘    └──────────────────────┘                │
│                                                                      │
│  ┌──────────────────────┐                                            │
│  │  Commenter un        │                                            │
│  │  signalement (mairie)│                                            │
│  └──────────────────────┘                                            │
└─────────────────────────────────────────────────────────────────────┘

   Acteurs :

   ┌───────┐                          ┌───────┐
   │       │  CITOYEN                 │       │  AGENT MAIRIE
   │  🧑   │  - Créer signalement     │  👤   │  - Tous les cas d'utilisation
   │       │  - Consulter             │       │  - Changer statut
   └───────┘  - Joindre photo         └───────┘  - Commenter
                                                  - Gérer catégories
```

---

## 2. Diagramme de Classes

```
┌──────────────────────────────────────┐
│              User                     │
├──────────────────────────────────────┤
│ - id : bigint (PK)                   │
│ - name : string                      │
│ - email : string (unique)            │
│ - password : string                  │
│ - role : enum [admin, agent, citoyen]│
│ - created_at : timestamp             │
│ - updated_at : timestamp             │
├──────────────────────────────────────┤
│ + isAdmin() : bool                   │
│ + isAgent() : bool                   │
└──────────────────────────────────────┘

┌──────────────────────────────────────┐         ┌──────────────────────────────────────┐
│           Categorie                   │         │           Signalement                 │
├──────────────────────────────────────┤         ├──────────────────────────────────────┤
│ - id : bigint (PK)                   │  1   *  │ - id : bigint (PK)                   │
│ - nom : string                       │◄────────│ - reference : string (unique)         │
│ - icone : string (nullable)          │         │ - titre : string                      │
│ - description : text (nullable)      │         │ - description : text                  │
│ - actif : boolean                    │         │ - categorie_id : bigint (FK)          │
│ - created_at : timestamp             │         │ - adresse : string                    │
│ - updated_at : timestamp             │         │ - quartier : string (nullable)        │
├──────────────────────────────────────┤         │ - latitude : decimal (nullable)       │
│ + signalements() : HasMany           │         │ - longitude : decimal (nullable)      │
│ + scopeActives() : Builder           │         │ - statut : enum [nouveau, en_cours,   │
└──────────────────────────────────────┘         │                  resolu, rejete]       │
                                                  │ - priorite : enum [faible, moyenne,   │
                                                  │                    haute, urgente]     │
                                                  │ - photo : string (nullable)            │
                                                  │ - signale_par : string                 │
                                                  │ - email_signaleur : string (nullable)  │
                                                  │ - telephone_signaleur : string (null)  │
                                                  │ - commentaire_mairie : text (nullable) │
                                                  │ - date_resolution : timestamp (null)   │
                                                  │ - created_at : timestamp               │
                                                  │ - updated_at : timestamp               │
                                                  ├──────────────────────────────────────┤
                                                  │ + categorie() : BelongsTo             │
                                                  │ + getStatutBadgeAttribute() : string  │
                                                  │ + getPrioriteBadgeAttribute() : string│
                                                  │ + getStatutLabelAttribute() : string  │
                                                  │ + scopeParStatut() : Builder          │
                                                  │ + scopeParPriorite() : Builder        │
                                                  │ + scopeParCategorie() : Builder       │
                                                  └──────────────────────────────────────┘
```

---

## 3. Diagramme Entité-Relation (MCD)

```
┌────────────┐          ┌──────────────┐           ┌──────────────┐
│   USERS    │          │  CATEGORIES  │           │ SIGNALEMENTS │
├────────────┤          ├──────────────┤           ├──────────────┤
│ PK id      │          │ PK id        │  1     *  │ PK id        │
│    name    │          │    nom       │───────────│ FK categorie │
│    email   │          │    icone     │           │    reference │
│    password│          │    descript. │           │    titre     │
│    role    │          │    actif     │           │    descript. │
└────────────┘          └──────────────┘           │    adresse   │
                                                    │    quartier  │
                                                    │    statut    │
                                                    │    priorite  │
                                                    │    photo     │
                                                    │    signale_  │
                                                    │    par       │
                                                    │    email_sig │
                                                    │    tel_sig   │
                                                    │    comment.  │
                                                    │    date_reso │
                                                    └──────────────┘
    Relations :
    - Une CATEGORIE possède plusieurs SIGNALEMENTS (1:N)
    - Un SIGNALEMENT appartient à une CATEGORIE
```

---

## 4. Diagramme d'Architecture MVC (Laravel)

```
┌─────────────────────────────────────────────────────────────────┐
│                        NAVIGATEUR                                │
│                     (Citoyen / Agent)                            │
└────────────────────────────┬────────────────────────────────────┘
                             │ HTTP Request
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                      ROUTES (web.php)                            │
│                                                                  │
│  GET  /                     → DashboardController@index          │
│  GET  /signalements         → SignalementController@index        │
│  GET  /signalements/create  → SignalementController@create       │
│  POST /signalements         → SignalementController@store        │
│  GET  /signalements/{id}    → SignalementController@show         │
│  GET  /signalements/{id}/edit → SignalementController@edit       │
│  PUT  /signalements/{id}    → SignalementController@update       │
│  DELETE /signalements/{id}  → SignalementController@destroy      │
│  PATCH /signalements/{id}/statut → SignalementController@statut  │
│  CRUD /categories           → CategorieController (resource)     │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                      CONTROLLERS                                 │
│                                                                  │
│  ┌──────────────────────────────────────────────┐               │
│  │ SignalementController                         │               │
│  │  - index()    : Liste + filtres + recherche   │               │
│  │  - create()   : Formulaire création           │               │
│  │  - store()    : Enregistrer + upload photo    │               │
│  │  - show()     : Détails complets              │               │
│  │  - edit()     : Formulaire modification       │               │
│  │  - update()   : Mise à jour + gestion statut  │               │
│  │  - destroy()  : Suppression + nettoyage photo │               │
│  │  - changerStatut() : Action rapide statut     │               │
│  └──────────────────────────────────────────────┘               │
│                                                                  │
│  ┌──────────────────────────────────────────────┐               │
│  │ CategorieController                           │               │
│  │  - index()   : Liste avec compteur            │               │
│  │  - create()  : Formulaire                     │               │
│  │  - store()   : Créer catégorie                │               │
│  │  - edit()    : Formulaire modification        │               │
│  │  - update()  : Mettre à jour                  │               │
│  │  - destroy() : Supprimer (si pas de signalements) │           │
│  └──────────────────────────────────────────────┘               │
│                                                                  │
│  ┌──────────────────────────────────────────────┐               │
│  │ DashboardController                           │               │
│  │  - index()   : Statistiques + graphiques      │               │
│  └──────────────────────────────────────────────┘               │
└────────────────────────────┬────────────────────────────────────┘
               │                             │
               ▼                             ▼
┌─────────────────────────┐   ┌──────────────────────────────────┐
│       MODELS             │   │           VIEWS (Blade)          │
│   (Eloquent ORM)         │   │                                  │
│                          │   │  layouts/app.blade.php            │
│  ┌────────────────────┐  │   │  dashboard/index.blade.php       │
│  │    Signalement     │  │   │  signalements/index.blade.php    │
│  │    Categorie       │  │   │  signalements/create.blade.php   │
│  │    User            │  │   │  signalements/show.blade.php     │
│  └────────────────────┘  │   │  signalements/edit.blade.php     │
│           │              │   │  categories/index.blade.php      │
│           ▼              │   │  categories/create.blade.php     │
│  ┌────────────────────┐  │   │  categories/edit.blade.php       │
│  │   Base de données  │  │   │                                  │
│  │   (MySQL/SQLite)   │  │   │  Interface : Bootstrap 5         │
│  └────────────────────┘  │   │  Icônes : Bootstrap Icons        │
└──────────────────────────┘   └──────────────────────────────────┘
```

---

## 5. Diagramme de Flux (Cycle de vie d'un signalement)

```
                    ┌─────────┐
                    │ CITOYEN │
                    └────┬────┘
                         │
                         ▼
              ┌─────────────────────┐
              │  Remplir formulaire │
              │  de signalement     │
              └──────────┬──────────┘
                         │
                         ▼
              ┌─────────────────────┐
              │  Validation des     │
              │  données            │
              └──────────┬──────────┘
                         │
                    ┌────┴────┐
                    │ Valide? │
                    └────┬────┘
               Non ◄────┤────► Oui
               │              │
               ▼              ▼
        ┌────────────┐  ┌──────────────────┐
        │ Afficher   │  │ Création avec    │
        │ erreurs    │  │ statut: NOUVEAU  │
        └────────────┘  │ ref: SIG-XXXXXXX │
                        └────────┬─────────┘
                                 │
                                 ▼
                    ┌────────────────────────┐
                    │     AGENT MAIRIE        │
                    │   Consulte le dashboard │
                    └────────────┬───────────┘
                                 │
                    ┌────────────┴───────────┐
                    │                        │
                    ▼                        ▼
           ┌──────────────┐        ┌──────────────┐
           │  EN COURS     │        │   REJETÉ     │
           │  (prise en    │        │  (non valide │
           │   charge)     │        │   ou doublon)│
           └───────┬──────┘        └──────────────┘
                   │
                   ▼
           ┌──────────────┐
           │   RÉSOLU      │
           │  (problème    │
           │   corrigé)    │
           │  + date       │
           │  résolution   │
           └──────────────┘
```

---

## 6. Diagramme de la Base de Données (Schéma physique)

```sql
-- Table : users
CREATE TABLE users (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    email       VARCHAR(255) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    role        ENUM('admin','agent','citoyen') DEFAULT 'citoyen',
    remember_token VARCHAR(100) NULL,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL
);

-- Table : categories
CREATE TABLE categories (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(255) NOT NULL,
    icone       VARCHAR(50) NULL,
    description TEXT NULL,
    actif       BOOLEAN DEFAULT TRUE,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL
);

-- Table : signalements
CREATE TABLE signalements (
    id                    BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reference             VARCHAR(255) NOT NULL UNIQUE,
    titre                 VARCHAR(255) NOT NULL,
    description           TEXT NOT NULL,
    categorie_id          BIGINT UNSIGNED NOT NULL,
    adresse               VARCHAR(255) NOT NULL,
    quartier              VARCHAR(255) NULL,
    latitude              DECIMAL(10,8) NULL,
    longitude             DECIMAL(11,8) NULL,
    statut                ENUM('nouveau','en_cours','resolu','rejete') DEFAULT 'nouveau',
    priorite              ENUM('faible','moyenne','haute','urgente') DEFAULT 'moyenne',
    photo                 VARCHAR(255) NULL,
    signale_par           VARCHAR(255) NOT NULL,
    email_signaleur       VARCHAR(255) NULL,
    telephone_signaleur   VARCHAR(20) NULL,
    commentaire_mairie    TEXT NULL,
    date_resolution       TIMESTAMP NULL,
    created_at            TIMESTAMP NULL,
    updated_at            TIMESTAMP NULL,

    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE CASCADE
);
```
