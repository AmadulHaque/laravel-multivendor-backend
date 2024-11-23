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
        Schema::create('account_charts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->nullable()->constrained('merchants')->cascadeOnDelete();
            $table->foreignId('account_type_id')->constrained('account_types')->onDelete('cascade');
            $table->string('account_name')->nullable();
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->enum('status', [1, 0])->default(1)->comment('1=active 0=inactive');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_charts');
    }
};
