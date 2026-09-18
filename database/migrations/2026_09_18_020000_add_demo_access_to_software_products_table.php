<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('software_products', function (Blueprint $table) {
            $table->string('demo_url')->nullable()->after('screenshots');
            $table->string('demo_login')->nullable()->after('demo_url');
            $table->string('demo_password')->nullable()->after('demo_login');
        });
    }

    public function down(): void
    {
        Schema::table('software_products', function (Blueprint $table) {
            $table->dropColumn(['demo_url', 'demo_login', 'demo_password']);
        });
    }
};
