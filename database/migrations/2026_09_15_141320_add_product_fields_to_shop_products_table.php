<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shop_products', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->string('slug')->nullable()->after('title');
            $table->text('description')->nullable()->after('slug');
            $table->longText('content')->nullable()->after('description');
            $table->string('image')->nullable()->after('content');
            $table->string('author')->nullable()->after('image');
            $table->decimal('price', 10, 2)->default(0)->after('author');
            $table->decimal('sale_price', 10, 2)->nullable()->after('price');
            $table->unsignedInteger('stock_quantity')->default(0)->after('sale_price');
            $table->string('sku')->nullable()->after('stock_quantity');
            $table->foreignId('category_id')->nullable()->after('sku')->constrained('categories')->nullOnDelete();
            $table->boolean('is_featured')->default(false)->after('category_id');
            $table->boolean('is_active')->default(true)->after('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropColumn([
                'title',
                'slug',
                'description',
                'content',
                'image',
                'author',
                'price',
                'sale_price',
                'stock_quantity',
                'sku',
                'is_featured',
                'is_active',
            ]);
        });
    }
};
