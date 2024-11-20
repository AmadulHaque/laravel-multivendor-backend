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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['division', 'district', 'city'])->comment('Location type: division, district, or city');
            $table->string('name')->comment('Name of the location');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('Parent location ID for hierarchical relationships');
            $table->foreign('parent_id')->references('id')->on('locations')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
