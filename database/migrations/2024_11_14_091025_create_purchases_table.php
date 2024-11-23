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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('merchants');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->string('ref_no')->nullable();
            $table->integer('purchase_status_id')->nullable()->default(0);
            $table->date('purchase_date')->nullable();
            $table->decimal('total_item', 10, 2)->nullable()->default(0);
            $table->decimal('total_discount_percentage', 10, 2)->nullable()->default(0);
            $table->decimal('total_discount_amount', 10, 2)->nullable()->default(0);
            $table->decimal('total_purchase_vat_percentage', 10, 2)->nullable()->default(0);
            $table->decimal('total_purchase_vat_amount', 10, 2)->nullable()->default(0);
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
        Schema::dropIfExists('purchases');
    }
};
