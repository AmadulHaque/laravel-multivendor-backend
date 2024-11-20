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
        Schema::create('order_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id'); // Tracking ID for vendor's shipping

            // Foreign keys
            $table->unsignedBigInteger('vendor_id'); // Vendor reference (must use unsignedBigInteger)
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade'); // Deleting a vendor will also delete related orders

            $table->unsignedBigInteger('order_id'); // Order reference (must use unsignedBigInteger)
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade'); // Deleting an order will also delete related order vendors

            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_vendors');
    }
};
