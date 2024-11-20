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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Basic product details
            $table->string('name');
            $table->index('name');
            $table->string('slug')->unique();
            $table->string('summery')->nullable();
            $table->longText('description')->nullable();

            // Foreign key to categories table
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

            // Stock and pricing
            $table->string('sku')->unique();
            $table->integer('stock')->default(0);
            $table->decimal('price', 10, 2)->default(0.00);

            // Sales and product status
            $table->integer('sales_count')->default(0);
            $table->enum('status', ['pending', 'active', 'inactive'])->default('pending');
            $table->boolean('is_popular')->default(false);

            // Vendor relationship (the vendor is a reference to the users table)
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('set null');

            // SEO and social media sharing details
            $table->string('tags')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_title')->nullable();

            // Soft deletes and timestamps
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
