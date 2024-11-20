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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id')->comment('References the customer who made the order');

            $table->unsignedBigInteger('customer_location_id')->comment('References the customer address location');

            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_landmark')->nullable();
            $table->char('customer_number');

            $table->string('invoice_id')->unique()->comment('Unique identifier for the invoice');

            // Price and discount details
            $table->integer('total_shipping_fee')->default(0);
            $table->integer('total_discount')->default(0);
            $table->integer('total_price')->default(0);
            $table->integer('total_amount')->default(0);

            // Charge and payment details
            $table->integer('charge')->default(0);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_location_id')->references('id')->on('locations')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
