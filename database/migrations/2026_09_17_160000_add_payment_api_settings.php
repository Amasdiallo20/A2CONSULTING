<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('payment_provider')->default('sandbox')->after('moov_money_number');
            $table->string('payment_mode')->default('sandbox')->after('payment_provider');
            $table->string('payment_currency', 10)->default('GNF')->after('payment_mode');
            $table->string('payment_api_url')->nullable()->after('payment_currency');
            $table->string('payment_api_key')->nullable()->after('payment_api_url');
            $table->string('payment_api_secret')->nullable()->after('payment_api_key');
            $table->string('payment_site_id')->nullable()->after('payment_api_secret');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_url')->nullable()->after('payment_reference');
            $table->string('payment_token')->nullable()->after('payment_url');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_provider',
                'payment_mode',
                'payment_currency',
                'payment_api_url',
                'payment_api_key',
                'payment_api_secret',
                'payment_site_id',
            ]);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_url', 'payment_token']);
        });
    }
};
