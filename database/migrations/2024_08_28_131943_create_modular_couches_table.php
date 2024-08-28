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
        Schema::create('modular_couches', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
        });
        Schema::create('modular_couch_parts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('couch_id')->constrained('modular_couches');
            $table->integer('price');
        });
        Schema::create('modular_couch_samples', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('couch_id')->constrained('modular_couches');
        });
        Schema::create('modular_couch_part_sample', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('sample_id')->constrained('modular_couch_samples');
            $table->foreignId('part_id')->constrained('modular_couch_parts');
            $table->integer('count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modular_couches');
    }
};
