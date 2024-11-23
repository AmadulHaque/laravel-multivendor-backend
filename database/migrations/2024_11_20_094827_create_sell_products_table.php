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
        Schema::create('sell_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('merchants');
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->string('invoice_no')->nullable();
            $table->date('sale_date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('total_item', 10, 2)->nullable()->default(0);
            $table->decimal('total_discount_percentage', 10, 2)->nullable()->default(0);
            $table->decimal('total_discount_amount', 10, 2)->nullable()->default(0);
            $table->decimal('total_sale_vat_percentage', 10, 2)->nullable()->default(0);
            $table->decimal('total_sale_vat_amount', 10, 2)->nullable()->default(0);
            $table->decimal('total_shipping_cost', 10, 2)->nullable()->default(0);
            $table->decimal('total_amount', 10, 2)->nullable()->default(0);
            $table->decimal('grand_total', 10, 2)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_products');
    }
};
