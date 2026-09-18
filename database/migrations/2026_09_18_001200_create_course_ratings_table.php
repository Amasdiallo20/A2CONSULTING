<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->string('visitor_key', 64);
            $table->timestamps();

            $table->unique(['course_id', 'visitor_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_ratings');
    }
};
