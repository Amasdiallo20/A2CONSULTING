<?php

namespace Database\Seeders;

use App\Models\SoftwareProduct;
use Illuminate\Database\Seeder;

class SoftwareProductSeeder extends Seeder
{
    public function run(): void
    {
        SoftwareProduct::updateOrCreate(
            ['slug' => 'a2stock'],
            [
                'name' => 'A2StocK',
                'tagline' => 'ERP de gestion pour entreprises',
                'description' => 'Application de gestion pour piloter facturation, stock, commandes et caisse dans un seul outil.',
                'content' => '<p>A2StocK centralise le quotidien commercial et logistique : ventes, stocks, commandes et encaissements. Idéal pour les commerces, dépôts et PME qui veulent suivre leurs flux en temps réel.</p><p>Nous accompagnons le paramétrage, la formation des équipes et le suivi après mise en service.</p>',
                'image' => 'images/course/cu-1.jpg',
                'youtube_url' => 'https://www.youtube.com/watch?v=M7lc1UVf-VE',
                'demo_url' => 'https://demo.a2-consulting.com/a2stock',
                'demo_login' => 'demo',
                'demo_password' => 'A2Stock2026',
                'screenshots' => [
                    'images/course/cu-1.jpg',
                    'images/shop-singel/ss-1.jpg',
                    'images/shop-singel/ss-2.jpg',
                    'images/about/about-2.jpg',
                    'images/course/cu-3.jpg',
                    'images/slider/s-1.jpg',
                ],
                'modules' => [
                    'Facturation',
                    'Gestion des stocks',
                    'Commandes',
                    'Caisse',
                    'Tableaux de bord',
                ],
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        SoftwareProduct::updateOrCreate(
            ['slug' => 'a2school'],
            [
                'name' => 'A2SchooL',
                'tagline' => 'Application de gestion scolaire',
                'description' => 'Logiciel pour administrer un établissement : inscriptions, scolarité, notes, présence et communication.',
                'content' => '<p>A2SchooL aide les écoles et instituts à suivre les élèves, les classes, les paiements de scolarité et le suivi pédagogique, avec un accès adapté à l’administration et aux enseignants.</p><p>Une démo permet de voir le paramétrage selon votre organisation (cycles, filières, tarifs).</p>',
                'image' => 'images/course/cu-2.jpg',
                'youtube_url' => 'https://www.facebook.com/facebook/videos/10153231379946729/',
                'demo_url' => 'https://demo.a2-consulting.com/a2school',
                'demo_login' => 'demo',
                'demo_password' => 'A2School2026',
                'screenshots' => [
                    'images/course/cu-2.jpg',
                    'images/course/cu-4.jpg',
                    'images/shop-singel/ss-s1.jpg',
                    'images/teachers/t-2.jpg',
                    'images/page-banner-2.jpg',
                    'images/shop-singel/ss-3.jpg',
                ],
                'modules' => [
                    'Inscriptions et dossiers élèves',
                    'Classes et emplois du temps',
                    'Notes et bulletins',
                    'Présences',
                    'Scolarité et paiements',
                ],
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        SoftwareProduct::updateOrCreate(
            ['slug' => 'a2resto'],
            [
                'name' => 'A2Resto',
                'tagline' => 'Gestion de restaurant',
                'description' => 'Simplifiez la gestion de votre restaurant avec notre logiciel de caisse. Une solution complète, rapide et simple à utiliser.',
                'content' => '<p>A2Resto aide les restaurants à encaisser, suivre les tables et piloter les ventes au quotidien. Prise de commandes, impression des tickets, paiements, stocks et rapports sont réunis dans une interface claire.</p><p>Nous paramétrons l’application selon votre salle, votre carte et votre organisation, puis formons vos équipes.</p>',
                'image' => 'images/course/cu-3.jpg',
                'youtube_url' => null,
                'demo_url' => 'https://demo.a2-consulting.com/a2resto',
                'demo_login' => 'demo',
                'demo_password' => 'A2Resto2026',
                'screenshots' => [
                    'images/course/cu-3.jpg',
                    'images/shop-singel/ss-1.jpg',
                    'images/shop-singel/ss-2.jpg',
                    'images/about/about-2.jpg',
                    'images/course/cu-1.jpg',
                    'images/slider/s-1.jpg',
                ],
                'modules' => [
                    'Prise de commandes rapide',
                    'Gestion des tables et des emplacements',
                    'Impression des tickets de caisse',
                    'Gestion des ventes et des paiements',
                    'Suivi des produits et des stocks',
                    'Historique des opérations et rapports détaillés',
                    'Interface simple et facile à utiliser',
                ],
                'sort_order' => 3,
                'is_active' => true,
            ]
        );
    }
}
