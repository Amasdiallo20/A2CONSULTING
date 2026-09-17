<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('delivery_mode', 20)->default('hybride')->after('category_id');
        });

        $modes = ['presentiel', 'en_ligne', 'hybride'];
        $index = 0;
        DB::table('courses')->orderBy('id')->get(['id'])->each(function ($course) use (&$index, $modes) {
            DB::table('courses')->where('id', $course->id)->update([
                'delivery_mode' => $modes[$index % 3],
            ]);
            $index++;
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('delivery_mode');
        });
    }
};
