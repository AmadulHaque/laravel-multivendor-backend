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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->enum('is_enable_accounting', [1, 0])->default(0)->comment('1=active 0=inactive');
            $table->integer('purchase_account_id')->nullable()->default(0);
            $table->integer('inventory_account_id')->nullable()->default(0);
            $table->integer('sale_account_id')->nullable()->default(0);
            $table->integer('selling_type_id')->nullable()->default(0);
            $table->decimal('regular_price', 10, 2)->default(0);
            $table->decimal('discount_price', 10, 2)->default(0);
            $table->decimal('wholesale_price', 10, 2)->default(0);
            $table->integer('minimum_qty')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
