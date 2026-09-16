<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Le cast "hashed" du modèle User hash déjà le mot de passe.
        User::updateOrCreate(
            ['email' => 'admin@a2consulting.com'],
            [
                'name' => 'Administrateur',
                'password' => 'admin123',
                'is_admin' => true,
            ]
        );

        $this->command->info('Utilisateur administrateur créé :');
        $this->command->info('Email: admin@a2consulting.com');
        $this->command->info('Mot de passe: admin123');
        $this->command->warn('⚠️  IMPORTANT: Changez ce mot de passe après la première connexion !');
    }
}



