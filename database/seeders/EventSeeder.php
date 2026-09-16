<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Journée portes ouvertes A2 Consulting',
                'description' => 'Découvrez nos formations, rencontrez les formateurs et posez toutes vos questions.',
                'content' => '<p>Une journée pour visiter le centre, assister à des mini-ateliers et construire votre parcours.</p>',
                'image' => 'images/event/e-1.jpg',
                'event_date' => '2026-10-10',
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'location' => 'Abidjan',
                'venue' => 'Siège A2 Consulting',
                'capacity' => 80,
                'price' => 0,
                'is_featured' => true,
            ],
            [
                'title' => 'Atelier LinkedIn et personal branding',
                'description' => 'Optimisez votre profil LinkedIn et apprenez à valoriser votre expertise en ligne.',
                'content' => '<p>Atelier pratique : photo, accroche, réseau et publication.</p>',
                'image' => 'images/event/e-2.jpg',
                'event_date' => '2026-11-05',
                'start_time' => '14:00:00',
                'end_time' => '17:30:00',
                'location' => 'Abidjan',
                'venue' => 'Salle de formation 2',
                'capacity' => 25,
                'price' => 15,
                'is_featured' => true,
            ],
            [
                'title' => 'Conférence transformation digitale',
                'description' => 'Retours d\'expérience sur la digitalisation des PME et des organisations.',
                'content' => '<p>Intervenants, cas concrets et session questions-réponses.</p>',
                'image' => 'images/event/e-3.jpg',
                'event_date' => '2026-12-03',
                'start_time' => '08:30:00',
                'end_time' => '12:30:00',
                'location' => 'Abidjan',
                'venue' => 'Hôtel Ivoire — salle conférence',
                'capacity' => 120,
                'price' => 25,
                'is_featured' => false,
            ],
            [
                'title' => 'Hackathon développement web',
                'description' => '48 heures pour concevoir une application en équipe, encadrés par nos formateurs.',
                'content' => '<p>Équipes de 3 à 5 personnes. Restauration comprise. Prix pour les 3 premiers projets.</p>',
                'image' => 'images/event/e-4.jpg',
                'event_date' => '2026-10-24',
                'start_time' => '08:00:00',
                'end_time' => '18:00:00',
                'location' => 'Abidjan',
                'venue' => 'Campus A2 Consulting',
                'capacity' => 40,
                'price' => 10,
                'is_featured' => true,
            ],
        ];

        foreach ($events as $event) {
            Event::firstOrCreate(
                ['slug' => Str::slug($event['title'])],
                array_merge($event, [
                    'slug' => Str::slug($event['title']),
                    'registered_count' => 0,
                    'is_active' => true,
                ])
            );
        }
    }
}
