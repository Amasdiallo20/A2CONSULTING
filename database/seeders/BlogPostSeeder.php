<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('email', 'admin@a2consulting.com')->first();

        $actualites = Category::firstOrCreate(
            ['slug' => 'blog-actualites'],
            ['name' => 'Actualités', 'type' => 'blog', 'is_active' => true, 'order' => 1]
        );
        $conseils = Category::firstOrCreate(
            ['slug' => 'blog-conseils'],
            ['name' => 'Conseils', 'type' => 'blog', 'is_active' => true, 'order' => 2]
        );
        $metiers = Category::firstOrCreate(
            ['slug' => 'blog-metiers'],
            ['name' => 'Métiers', 'type' => 'blog', 'is_active' => true, 'order' => 3]
        );

        $posts = [
            [
                'title' => 'Comment bien choisir sa formation professionnelle',
                'excerpt' => 'Objectifs, rythme, débouchés : les critères pour sélectionner un parcours qui vous correspond.',
                'content' => '<p>Choisir une formation ne se limite pas au titre du programme. Clarifiez votre objectif, le temps dont vous disposez et le niveau attendu à l\'arrivée.</p><p>Chez A2 Consulting, nos conseillers vous aident à construire un parcours réaliste, en présentiel ou à distance.</p>',
                'image' => 'images/news/n-1.jpg',
                'category_id' => $conseils->id,
                'tags' => 'formation,orientation',
                'is_featured' => true,
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'Marketing digital : 5 tendances à suivre en 2026',
                'excerpt' => 'Contenu court, preuve sociale, données first-party : ce qui compte vraiment cette année.',
                'content' => '<p>Les plateformes évoluent vite, mais les fondamentaux restent : connaître son audience, mesurer, et produire un contenu utile.</p><ul><li>Vidéo courte</li><li>Communautés</li><li>SEO sémantique</li><li>Automatisation raisonnée</li></ul>',
                'image' => 'images/news/ns-1.jpg',
                'category_id' => $actualites->id,
                'tags' => 'marketing,digital',
                'is_featured' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Réussir sa reconversion vers le développement web',
                'excerpt' => 'HTML, JavaScript, un premier projet : une feuille de route simple pour changer de métier.',
                'content' => '<p>La reconversion est possible sans diplôme informatique, à condition d\'un rythme régulier et de projets concrets à montrer.</p><p>Nos formations PHP, Laravel et JavaScript sont conçues pour des profils en transition.</p>',
                'image' => 'images/news/ns-2.jpg',
                'category_id' => $metiers->id,
                'tags' => 'reconversion,web',
                'is_featured' => false,
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Excel : 7 astuces pour gagner du temps au bureau',
                'excerpt' => 'Raccourcis, tableaux croisés et mises en forme : des gestes simples, un vrai gain de productivité.',
                'content' => '<p>Beaucoup d\'utilisateurs d\'Excel n\'exploitent qu\'une petite partie de l\'outil. Ces 7 réflexes changent le quotidien.</p>',
                'image' => 'images/news/ns-3.jpg',
                'category_id' => $conseils->id,
                'tags' => 'excel,productivité',
                'is_featured' => false,
                'published_at' => now()->subDay(),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::firstOrCreate(
                ['slug' => Str::slug($post['title'])],
                array_merge($post, [
                    'slug' => Str::slug($post['title']),
                    'author_id' => $author?->id,
                    'is_published' => true,
                ])
            );
        }
    }
}
