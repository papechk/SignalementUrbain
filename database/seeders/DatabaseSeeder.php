<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;
use App\Models\Signalement;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ========== UTILISATEURS ==========
        User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Agent Municipal',
            'email'    => 'agent@mairie.fr',
            'password' => Hash::make('password'),
            'role'     => 'agent',
        ]);

        // Faux citoyens pour tester
        $citoyens = [
            ['name' => 'Moussa Diop',      'email' => 'moussa.diop@email.com'],
            ['name' => 'Fatou Ndiaye',      'email' => 'fatou.ndiaye@email.com'],
            ['name' => 'Abdoulaye Fall',    'email' => 'abdoulaye.fall@email.com'],
            ['name' => 'Aissatou Ba',       'email' => 'aissatou.ba@email.com'],
            ['name' => 'Ibrahima Sow',      'email' => 'ibrahima.sow@email.com'],
            ['name' => 'Aminata Sarr',      'email' => 'aminata.sarr@email.com'],
            ['name' => 'Ousmane Diallo',    'email' => 'ousmane.diallo@email.com'],
            ['name' => 'Mariama Gueye',     'email' => 'mariama.gueye@email.com'],
        ];

        foreach ($citoyens as $c) {
            User::create([
                'name'     => $c['name'],
                'email'    => $c['email'],
                'password' => Hash::make('password'),
                'role'     => 'citoyen',
            ]);
        }

        // ========== CATÉGORIES ==========
        $categories = [
            ['nom' => 'Voirie',              'icone' => 'cone-striped',       'description' => 'Nids-de-poule, chaussée dégradée, trottoirs abîmés'],
            ['nom' => 'Éclairage public',    'icone' => 'lightbulb',          'description' => 'Lampadaires en panne, zones non éclairées'],
            ['nom' => 'Propreté',            'icone' => 'trash',              'description' => 'Dépôts sauvages, poubelles débordantes, déchets'],
            ['nom' => 'Espaces verts',       'icone' => 'tree',               'description' => 'Arbres dangereux, parcs mal entretenus, haies'],
            ['nom' => 'Signalisation',       'icone' => 'sign-stop',          'description' => 'Panneaux manquants, feux de circulation en panne'],
            ['nom' => 'Eau & Assainissement','icone' => 'droplet',            'description' => 'Fuites d\'eau, bouches d\'égout bouchées, inondations'],
            ['nom' => 'Nuisances sonores',   'icone' => 'volume-up',          'description' => 'Bruit excessif, travaux bruyants, voisinage'],
            ['nom' => 'Stationnement',       'icone' => 'p-circle',           'description' => 'Véhicules gênants, stationnement illicite'],
            ['nom' => 'Bâtiments publics',   'icone' => 'building',           'description' => 'Dégradations, accessibilité, entretien'],
            ['nom' => 'Autre',               'icone' => 'question-circle',    'description' => 'Signalements ne rentrant dans aucune catégorie'],
        ];

        foreach ($categories as $cat) {
            Categorie::create($cat);
        }

        // ========== SIGNALEMENTS DE DÉMONSTRATION ==========
        $signalements = [
            [
                'titre'               => 'Nid-de-poule dangereux avenue de la République',
                'description'          => 'Un nid-de-poule de grande taille s\'est formé au niveau du numéro 45 de l\'avenue de la République. Plusieurs automobilistes ont déjà endommagé leurs véhicules. Le trou fait environ 30 cm de diamètre et 15 cm de profondeur.',
                'categorie_id'         => 1,
                'adresse'              => '45 Avenue de la République',
                'quartier'             => 'Centre-ville',
                'latitude'             => 14.6928,
                'longitude'            => -17.4467,
                'statut'               => 'en_cours',
                'priorite'             => 'haute',
                'signale_par'          => 'Moussa Diop',
                'email_signaleur'      => 'moussa.diop@email.com',
                'telephone_signaleur'  => '77 123 45 67',
                'commentaire_mairie'   => 'Intervention programmée pour la semaine prochaine.',
            ],
            [
                'titre'               => 'Lampadaire en panne rue des Lilas',
                'description'          => 'Le lampadaire situé devant le numéro 12 de la rue des Lilas ne fonctionne plus depuis 3 jours. La rue est très sombre le soir, ce qui pose un problème de sécurité pour les piétons.',
                'categorie_id'         => 2,
                'adresse'              => '12 Rue des Lilas',
                'quartier'             => 'Les Fleurs',
                'latitude'             => 14.7005,
                'longitude'            => -17.4553,
                'statut'               => 'nouveau',
                'priorite'             => 'moyenne',
                'signale_par'          => 'Fatou Ndiaye',
                'email_signaleur'      => 'fatou.ndiaye@email.com',
                'telephone_signaleur'  => '76 345 67 89',
            ],
            [
                'titre'               => 'Dépôt sauvage d\'encombrants',
                'description'          => 'Des encombrants (canapé, matelas, électroménager) ont été abandonnés sur le trottoir au coin de la rue du Commerce et de la place du Marché. Cela gêne le passage des piétons et donne une mauvaise image du quartier.',
                'categorie_id'         => 3,
                'adresse'              => 'Angle rue du Commerce / Place du Marché',
                'quartier'             => 'Marché',
                'latitude'             => 14.6860,
                'longitude'            => -17.4410,
                'statut'               => 'nouveau',
                'priorite'             => 'urgente',
                'signale_par'          => 'Abdoulaye Fall',
                'email_signaleur'      => 'abdoulaye.fall@email.com',
            ],
            [
                'titre'               => 'Arbre déraciné au parc municipal',
                'description'          => 'Suite aux vents violents de la nuit dernière, un grand chêne s\'est partiellement déraciné dans le parc municipal. Il penche dangereusement vers l\'aire de jeux pour enfants. Intervention urgente nécessaire.',
                'categorie_id'         => 4,
                'adresse'              => 'Parc Municipal',
                'quartier'             => 'Centre-ville',
                'latitude'             => 14.6950,
                'longitude'            => -17.4500,
                'statut'               => 'en_cours',
                'priorite'             => 'urgente',
                'signale_par'          => 'Aissatou Ba',
                'telephone_signaleur'  => '78 678 90 12',
                'commentaire_mairie'   => 'Équipe d\'intervention en route. Zone sécurisée.',
            ],
            [
                'titre'               => 'Feu tricolore en panne au carrefour principal',
                'description'          => 'Le feu tricolore du carrefour entre le boulevard Victor Hugo et la rue Pasteur clignote en orange en permanence. Plusieurs accrochages mineurs ont eu lieu.',
                'categorie_id'         => 5,
                'adresse'              => 'Carrefour Bd Victor Hugo / Rue Pasteur',
                'quartier'             => 'Pasteur',
                'latitude'             => 14.6890,
                'longitude'            => -17.4380,
                'statut'               => 'resolu',
                'priorite'             => 'haute',
                'signale_par'          => 'Ibrahima Sow',
                'email_signaleur'      => 'ibrahima.sow@email.com',
                'commentaire_mairie'   => 'Feu réparé le 28/02/2026 par notre équipe technique.',
                'date_resolution'      => '2026-02-28 14:30:00',
            ],
            [
                'titre'               => 'Fuite d\'eau importante rue de la Fontaine',
                'description'          => 'Une fuite d\'eau importante a été constatée au niveau de la bouche d\'incendie située devant le numéro 8 de la rue de la Fontaine. L\'eau coule en permanence sur la chaussée.',
                'categorie_id'         => 6,
                'adresse'              => '8 Rue de la Fontaine',
                'quartier'             => 'Centre-ville',
                'latitude'             => 14.6975,
                'longitude'            => -17.4425,
                'statut'               => 'en_cours',
                'priorite'             => 'haute',
                'signale_par'          => 'Aminata Sarr',
                'telephone_signaleur'  => '70 890 12 34',
                'commentaire_mairie'   => 'Service des eaux alerté.',
            ],
            [
                'titre'               => 'Trottoir cassé devant l\'école',
                'description'          => 'Le trottoir devant l\'école primaire Jean Moulin est très abîmé avec des dalles soulevées. Risque de chute pour les enfants et les parents.',
                'categorie_id'         => 1,
                'adresse'              => '20 Rue Jean Moulin',
                'quartier'             => 'Jean Moulin',
                'latitude'             => 14.7020,
                'longitude'            => -17.4480,
                'statut'               => 'nouveau',
                'priorite'             => 'haute',
                'signale_par'          => 'Ousmane Diallo',
                'email_signaleur'      => 'ousmane.diallo@email.com',
            ],
            [
                'titre'               => 'Poubelles non ramassées depuis 3 jours',
                'description'          => 'Les poubelles de la résidence des Acacias n\'ont pas été collectées depuis 3 jours. Les conteneurs débordent et des déchets se répandent sur la voie publique.',
                'categorie_id'         => 3,
                'adresse'              => 'Résidence des Acacias, Rue des Acacias',
                'quartier'             => 'Les Acacias',
                'latitude'             => 14.6845,
                'longitude'            => -17.4520,
                'statut'               => 'resolu',
                'priorite'             => 'moyenne',
                'signale_par'          => 'Mariama Gueye',
                'email_signaleur'      => 'mariama.gueye@email.com',
                'commentaire_mairie'   => 'Service de collecte intervenu. Problème de camion en panne résolu.',
                'date_resolution'      => '2026-03-01 09:00:00',
            ],
            [
                'titre'               => 'Véhicule abandonné depuis plusieurs semaines',
                'description'          => 'Une voiture non immatriculée semble abandonnée depuis au moins 3 semaines sur le parking public de la Place de la Mairie. Elle est sur cales et présente des vitres cassées.',
                'categorie_id'         => 8,
                'adresse'              => 'Parking Place de la Mairie',
                'quartier'             => 'Centre-ville',
                'latitude'             => 14.6910,
                'longitude'            => -17.4450,
                'statut'               => 'nouveau',
                'priorite'             => 'faible',
                'signale_par'          => 'Moussa Diop',
                'telephone_signaleur'  => '77 123 45 67',
            ],
            [
                'titre'               => 'Graffitis sur le mur de la médiathèque',
                'description'          => 'Des graffitis injurieux ont été tagués sur le mur extérieur de la médiathèque municipale côté parking. Cela nuit à l\'image de l\'établissement.',
                'categorie_id'         => 9,
                'adresse'              => 'Médiathèque Municipale, Rue de la Culture',
                'quartier'             => 'Culture',
                'latitude'             => 14.6870,
                'longitude'            => -17.4350,
                'statut'               => 'rejete',
                'priorite'             => 'faible',
                'signale_par'          => 'Fatou Ndiaye',
                'email_signaleur'      => 'fatou.ndiaye@email.com',
                'commentaire_mairie'   => 'Pris en charge directement par le service des bâtiments publics.',
            ],
        ];

        foreach ($signalements as $sig) {
            $sig['reference'] = 'SIG-' . strtoupper(Str::random(8));
            Signalement::create($sig);
        }
    }
}
