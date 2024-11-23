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
        Schema::create('stock_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variation_id')->nullable()->constrained('product_variations');
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->decimal('regular_price', 10, 2)->nullable()->default(0);
            $table->decimal('discount_price', 10, 2)->nullable()->default(0);
            $table->decimal('wholesale_price', 10, 2)->nullable()->default(0);
            $table->integer('stock_qty')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_inventories');
    }
};
