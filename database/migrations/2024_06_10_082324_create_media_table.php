<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            $table->morphs('model');
            $table->string('collection_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->string('tags')->nullable();

            $table->nullableTimestamps();
        });
    }
};