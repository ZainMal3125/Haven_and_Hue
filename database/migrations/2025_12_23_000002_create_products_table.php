<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('material_type'); // Mapped from 'material' in JSON to 'material_type' in schema
            $table->string('dimensions');
            $table->integer('stock');
            // 'images' is handled in product_images table, but prompt schema says 'images' in Products table?? 
            // "Products Table: ... images ..."
            // BUT also "Product_Images Table".
            // Likely 'images' in Products is redundant or a JSON cache. I will add it as nullable text/json just in case, but rely on the relations.
            // Actually, let's just stick to the relations for purity, unless requested. 
            // The JSON sample has "images": ["...", "..."], so maybe a JSON column?
            // "Product hasMany Product_Images".
            // I'll skip 'images' column here and use the relation table as it's more normalized.
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
