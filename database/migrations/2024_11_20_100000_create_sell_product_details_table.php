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
        Schema::create('sell_product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sell_product_id')->constrained('sell_products');
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->foreignId('variation_attribute_id')->nullable()->constrained('variation_attributes');
            $table->decimal('sale_qty', 10, 2)->nullable()->default(0);
            $table->decimal('unit_cost', 10, 2)->nullable()->default(0);
            $table->decimal('product_discount_percentage', 10, 2)->nullable()->default(0);
            $table->decimal('product_vat', 10, 2)->nullable()->default(0);
            $table->decimal('sub_total', 10, 2)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_product_details');
    }
};