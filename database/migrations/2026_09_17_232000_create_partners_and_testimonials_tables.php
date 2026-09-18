<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('website_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('role')->nullable();
            $table->string('company')->nullable();
            $table->text('quote');
            $table->string('photo')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();

        DB::table('partners')->insert([
            ['name' => 'Banque Centrale', 'logo' => null, 'website_url' => null, 'sort_order' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Chambre de Commerce', 'logo' => null, 'website_url' => null, 'sort_order' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Orange Guinée', 'logo' => null, 'website_url' => null, 'sort_order' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'PNUD', 'logo' => null, 'website_url' => null, 'sort_order' => 4, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('testimonials')->insert([
            [
                'client_name' => 'Fatoumata Diallo',
                'role' => 'Responsable RH',
                'company' => 'Entreprise partenaire',
                'quote' => 'Les formations A2 Consulting ont transformé nos équipes. Le suivi est concret, humain et parfaitement adapté à nos enjeux.',
                'photo' => null,
                'rating' => 5,
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'client_name' => 'Ibrahima Camara',
                'role' => 'Directeur commercial',
                'company' => 'PME Conakry',
                'quote' => 'Un accompagnement sérieux, des formateurs experts et des résultats visibles dès les premières semaines.',
                'photo' => null,
                'rating' => 5,
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'client_name' => 'Aïssatou Bah',
                'role' => 'Comptable',
                'company' => 'Cabinet indépendant',
                'quote' => 'J’ai suivi le parcours comptabilité : clair, pratique, et directement applicable au quotidien.',
                'photo' => null,
                'rating' => 5,
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('partners');
    }
};
