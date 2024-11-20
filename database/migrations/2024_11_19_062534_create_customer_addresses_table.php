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
        Schema::disableForeignKeyConstraints();

        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('References the user who owns the address');
            $table->unsignedBigInteger('location_id')->comment('References the location of the address');
            $table->string('name', 50)->comment('Name associated with the address');
            $table->string('landmark', 100)->nullable()->comment('Nearby landmark for easier identification');
            $table->string('address',150)->comment('Detailed address');
            $table->boolean('is_default_bill')->default(false)->comment('True if default billing address');
            $table->boolean('is_default_ship')->default(false)->comment('True if default shipping address');
            $table->enum('address_type', ['home', 'office'])->default('home')->comment('Type of address: home or office');
            $table->char('contact_number')->comment('Contact number associated with the address');
            $table->boolean('status')->default(false)->comment('true=active, false=inactive');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->timestamps();
        });


        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
