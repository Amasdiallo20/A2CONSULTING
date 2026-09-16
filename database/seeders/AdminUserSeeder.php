<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur administrateur par défaut
        User::firstOrCreate(
            ['email' => 'admin@a2consulting.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        $this->command->info('Utilisateur administrateur créé :');
        $this->command->info('Email: admin@a2consulting.com');
        $this->command->info('Mot de passe: admin123');
        $this->command->warn('⚠️  IMPORTANT: Changez ce mot de passe après la première connexion !');
    }
}



