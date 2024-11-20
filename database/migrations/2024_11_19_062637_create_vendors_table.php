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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id(); // Primary key

            // Foreign key to reference the user who is the vendor
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Store name, address, and store URL for the vendor
            $table->string('store_name');
            $table->string('address');
            $table->string('store_url')->unique(); // Ensure unique URL for each vendor's store

            // Contact number (nullable, in case it's not provided)
            $table->char('contact_number', 15)->nullable(); // Specify length for contact number for consistency

            // Vendor status (active/inactive)
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
