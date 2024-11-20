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

        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status_name')->unique()->comment('Name of the status');
            $table->string('text_color')->nullable()->comment('Text color for display purposes');
            $table->string('bg_color')->nullable()->comment('Background color for display purposes');
            $table->integer('sort_id')->default(0)->comment('Sorting order for statuses');
            $table->string('message')->nullable()->comment('Associated message for the status');
            $table->string('model_name')->nullable()->comment('Associated model for the status');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
