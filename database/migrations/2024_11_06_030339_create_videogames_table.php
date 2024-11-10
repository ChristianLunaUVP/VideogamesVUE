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
        Schema::create('videogames', function (Blueprint $table) {
            $table->id();
            $table->string('name',80);
            $table->string('description',500);
            $table->string('type',80);
            $table->string('genre',80);
            $table->string('image',1024);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videogames');
    }
};
