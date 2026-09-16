<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->string('slug')->nullable()->after('title');
            $table->text('excerpt')->nullable()->after('slug');
            $table->longText('content')->nullable()->after('excerpt');
            $table->string('image')->nullable()->after('content');
            $table->foreignId('author_id')->nullable()->after('image')->constrained('users')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->after('author_id')->constrained('categories')->nullOnDelete();
            $table->string('tags')->nullable()->after('category_id');
            $table->boolean('is_featured')->default(false)->after('tags');
            $table->boolean('is_published')->default(false)->after('is_featured');
            $table->timestamp('published_at')->nullable()->after('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('author_id');
            $table->dropConstrainedForeignId('category_id');
            $table->dropColumn([
                'title', 'slug', 'excerpt', 'content', 'image', 'tags',
                'is_featured', 'is_published', 'published_at',
            ]);
        });
    }
};
