<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Conseil en stratégie et organisation',
                'description' => 'Diagnostic, feuille de route et accompagnement pour structurer votre organisation.',
                'content' => '<p>Nous aidons les dirigeants à clarifier leurs priorités, aligner les équipes et mettre en place un plan d\'action réaliste.</p><ul><li>Diagnostic organisationnel</li><li>Cadrage stratégique</li><li>Suivi des chantiers</li></ul>',
                'image' => 'images/about/about-2.jpg',
                'icon' => 'fa fa-sitemap',
                'price' => null,
                'price_type' => 'custom',
                'order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Accompagnement transformation digitale',
                'description' => 'Outils, process et formation des équipes pour digitaliser votre activité.',
                'content' => '<p>De l\'audit de l\'existant au déploiement d\'outils (CRM, site, automatisation) avec la montée en compétence des collaborateurs.</p>',
                'image' => 'images/course/cu-1.jpg',
                'icon' => 'fa fa-laptop',
                'price' => null,
                'price_type' => 'custom',
                'order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Audit comptable et financier',
                'description' => 'Revue de vos process, de la qualité des comptes et des indicateurs de gestion.',
                'content' => '<p>Un regard extérieur sur la fiabilité de l\'information financière et les leviers d\'amélioration.</p>',
                'image' => 'images/course/cu-3.jpg',
                'icon' => 'fa fa-calculator',
                'price' => 750,
                'price_type' => 'per_session',
                'order' => 3,
                'is_featured' => true,
            ],
            [
                'title' => 'Formation intra-entreprise',
                'description' => 'Programmes sur mesure (web, marketing, comptabilité, anglais) dans vos locaux ou à distance.',
                'content' => '<p>Nous concevons un parcours adapté à vos métiers, votre niveau et votre calendrier.</p>',
                'image' => 'images/course/cu-2.jpg',
                'icon' => 'fa fa-users',
                'price' => null,
                'price_type' => 'custom',
                'order' => 4,
                'is_featured' => true,
            ],
            [
                'title' => 'Recrutement et appui RH',
                'description' => 'Aide au recrutement, fiches de poste, intégration et montée en compétences.',
                'content' => '<p>Un appui pour attirer, sélectionner et fidéliser les profils dont vous avez besoin.</p>',
                'image' => 'images/teachers/t-2.jpg',
                'icon' => 'fa fa-id-badge',
                'price' => null,
                'price_type' => 'custom',
                'order' => 5,
                'is_featured' => false,
            ],
            [
                'title' => 'Création de site web et application',
                'description' => 'Conception, développement et mise en ligne de sites vitrine, e-commerce ou outils métier.',
                'content' => '<p>Étude, maquettes, développement Laravel et formation à la prise en main.</p>',
                'image' => 'images/course/cu-4.jpg',
                'icon' => 'fa fa-code',
                'price' => null,
                'price_type' => 'custom',
                'order' => 6,
                'is_featured' => false,
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(
                ['slug' => Str::slug($service['title'])],
                array_merge($service, [
                    'slug' => Str::slug($service['title']),
                    'is_active' => true,
                ])
            );
        }
    }
}
