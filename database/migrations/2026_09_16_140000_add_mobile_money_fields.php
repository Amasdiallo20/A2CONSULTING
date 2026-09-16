<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('status');
            $table->string('payment_operator')->nullable()->after('payment_method');
            $table->string('momo_phone')->nullable()->after('payment_operator');
            $table->string('payment_status')->default('awaiting')->after('momo_phone');
            $table->string('payment_reference')->nullable()->after('payment_status');
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('orange_money_number')->nullable();
            $table->string('mtn_money_number')->nullable();
            $table->string('moov_money_number')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'payment_operator',
                'momo_phone',
                'payment_status',
                'payment_reference',
            ]);
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['orange_money_number', 'mtn_money_number', 'moov_money_number']);
        });
    }
};
