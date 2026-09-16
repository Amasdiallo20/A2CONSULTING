<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $setting = SiteSetting::current();

        $defaults = [
            'site_name' => 'A2 Consulting',
            'phone' => '+224 613 92 69 92',
            'email' => 'contact@a2-consulting.com',
            'address' => 'Conakry, Guinée, Cosa Rond-point',
            'opening_hours' => 'Lun – Ven : 8h00 – 18h00',
            'facebook' => 'https://facebook.com',
            'twitter' => 'https://twitter.com',
            'instagram' => 'https://instagram.com',
            'linkedin' => 'https://linkedin.com',
            'hero_title' => 'Formez-vous. Progressez. Réussissez.',
            'hero_subtitle' => 'A2 Consulting accompagne les particuliers et les entreprises avec des formations, du conseil et des services sur mesure.',
            'hero_image' => 'images/slider/s-1.jpg',
            'hero_button_text' => 'Voir les formations',
            'hero_button_url' => '/courses',
            'about_title' => 'Un cabinet de formation et de conseil',
            'about_text' => '<p>A2 Consulting est un cabinet de formation et de conseil. Nous concevons des parcours concrets en développement web, marketing digital, gestion de projet, comptabilité, anglais et data.</p><p>Notre équipe de formateurs intervient en présentiel et à distance, pour les particuliers comme pour les entreprises (intra et inter).</p>',
            'about_image' => 'images/about/about-2.jpg',
            'orange_money_number' => '+224 613 92 69 92',
            'mtn_money_number' => '+224 613 92 69 92',
            'moov_money_number' => '+224 613 92 69 92',
        ];

        foreach ($defaults as $field => $value) {
            if (blank($setting->{$field})) {
                $setting->{$field} = $value;
            }
        }

        $setting->save();
    }
}
