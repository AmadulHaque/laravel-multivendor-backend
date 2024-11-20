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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Foreign key to reference the order status
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');

            // Foreign key to reference the vendor's order
            $table->unsignedBigInteger('order_vendor_id');
            $table->foreign('order_vendor_id')->references('id')->on('order_vendors')->onDelete('cascade');

            // Foreign key to reference the product
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Foreign key to reference the product variation
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('set null');

            // Quantity and price of the product for the order item
            $table->integer('quantity')->default(1);
            $table->integer('price')->comment('Price per unit of the product');

            $table->timestamps(); // Created at and updated at timestamps
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
