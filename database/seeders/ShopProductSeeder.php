<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ShopProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShopProductSeeder extends Seeder
{
    public function run(): void
    {
        $livres = Category::where('slug', 'livres')->where('type', 'shop')->first();
        $fournitures = Category::where('slug', 'fournitures')->where('type', 'shop')->first();
        $magazines = Category::where('slug', 'magazines')->where('type', 'shop')->first();
        $accessoires = Category::where('slug', 'accessoires')->where('type', 'shop')->first();

        $products = [
            [
                'title' => 'Guide pratique Laravel',
                'description' => 'Manuel de référence pour concevoir des applications Laravel propres et maintenables.',
                'content' => '<p>Du routage aux files d\'attente, avec exercices. Idéal en complément de nos formations web.</p>',
                'image' => 'images/publication/p-1.jpg',
                'author' => 'A2 Consulting',
                'price' => 29.90,
                'sale_price' => 24.90,
                'stock_quantity' => 40,
                'sku' => 'LIV-LAR-001',
                'category_id' => $livres?->id,
                'is_featured' => true,
            ],
            [
                'title' => 'Marketing digital de A à Z',
                'description' => 'Un ouvrage clair sur le SEO, les réseaux sociaux et la publicité en ligne.',
                'content' => '<p>Cas pratiques et check-lists pour lancer ou structurer une stratégie digitale.</p>',
                'image' => 'images/publication/p-2.jpg',
                'author' => 'Marie Martin',
                'price' => 22.50,
                'sale_price' => null,
                'stock_quantity' => 35,
                'sku' => 'LIV-MKT-002',
                'category_id' => $livres?->id,
                'is_featured' => true,
            ],
            [
                'title' => 'Cahier de notes A4 ligné',
                'description' => 'Cahier 96 pages, couverture rigide, pour le suivi de formation.',
                'content' => '<p>Format A4, papier 80 g. Pratique en salle comme à distance.</p>',
                'image' => 'images/publication/p-3.jpg',
                'author' => null,
                'price' => 4.50,
                'sale_price' => 3.90,
                'stock_quantity' => 120,
                'sku' => 'FOU-CAH-010',
                'category_id' => $fournitures?->id,
                'is_featured' => false,
            ],
            [
                'title' => 'Pack stylos et surligneurs',
                'description' => '6 stylos et 4 surligneurs pour annoter vos supports de cours.',
                'content' => '<p>Encre fluide, couleurs assorties A2 Consulting.</p>',
                'image' => 'images/publication/p-4.jpg',
                'author' => null,
                'price' => 6.90,
                'sale_price' => null,
                'stock_quantity' => 80,
                'sku' => 'FOU-STY-011',
                'category_id' => $fournitures?->id,
                'is_featured' => false,
            ],
            [
                'title' => 'Magazine Compétences n°12',
                'description' => 'Dossier : reconversion, métiers du digital et témoignages d\'apprenants.',
                'content' => '<p>Numéro trimestriel édité avec nos formateurs et partenaires.</p>',
                'image' => 'images/publication/p-5.jpg',
                'author' => 'Rédaction A2',
                'price' => 5.00,
                'sale_price' => null,
                'stock_quantity' => 60,
                'sku' => 'MAG-CMP-012',
                'category_id' => $magazines?->id,
                'is_featured' => true,
            ],
            [
                'title' => 'Sacoche ordinateur 15 pouces',
                'description' => 'Sacoche rembourrée, bandoulière, compartiment documents.',
                'content' => '<p>Convient aux formations en présentiel et aux déplacements professionnels.</p>',
                'image' => 'images/publication/p-6.jpg',
                'author' => null,
                'price' => 39.90,
                'sale_price' => 34.90,
                'stock_quantity' => 18,
                'sku' => 'ACC-SAC-020',
                'category_id' => $accessoires?->id,
                'is_featured' => true,
            ],
            [
                'title' => 'Clé USB 64 Go A2 Consulting',
                'description' => 'Support de cours et travaux pratiques, livrée avec étui.',
                'content' => '<p>USB 3.0, 64 Go. Idéale pour récupérer les ressources de formation.</p>',
                'image' => 'images/publication/p-7.jpg',
                'author' => null,
                'price' => 12.90,
                'sale_price' => null,
                'stock_quantity' => 50,
                'sku' => 'ACC-USB-021',
                'category_id' => $accessoires?->id,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $product) {
            ShopProduct::firstOrCreate(
                ['slug' => Str::slug($product['title'])],
                array_merge($product, [
                    'slug' => Str::slug($product['title']),
                    'is_active' => true,
                ])
            );
        }
    }
}
