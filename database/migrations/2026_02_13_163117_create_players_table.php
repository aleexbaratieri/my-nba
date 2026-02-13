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
        Schema::create('players', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('player_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('position')->nullable();
            $table->string('height')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('jersey_number')->nullable();
            $table->string('college')->nullable();
            $table->string('country')->nullable(); 
            $table->integer('draft_year')->nullable();
            $table->integer('draft_round')->nullable();
            $table->integer('draft_number')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->timestamps();

            $table->foreign('team_id')->references('team_id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
