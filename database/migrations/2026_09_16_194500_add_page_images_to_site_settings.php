<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('logo_image')->nullable();
            $table->string('favicon_image')->nullable();
            $table->string('about_bg_image')->nullable();
            $table->string('banner_about')->nullable();
            $table->string('banner_courses')->nullable();
            $table->string('banner_services')->nullable();
            $table->string('banner_events')->nullable();
            $table->string('banner_teachers')->nullable();
            $table->string('banner_blog')->nullable();
            $table->string('banner_shop')->nullable();
            $table->string('banner_contact')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'logo_image',
                'favicon_image',
                'about_bg_image',
                'banner_about',
                'banner_courses',
                'banner_services',
                'banner_events',
                'banner_teachers',
                'banner_blog',
                'banner_shop',
                'banner_contact',
            ]);
        });
    }
};
