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
        Schema::create('games', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->date('date');
            $table->integer('season');
            $table->string('status');
            $table->integer('period')->nullable();
            $table->string('time')->nullable();
            $table->boolean('postseason')->nullable();
            $table->boolean('postponed')->nullable();
            $table->integer('home_team_score')->nullable();
            $table->integer('away_team_score')->nullable();
            $table->dateTime('datetime')->nullable();
            $table->integer('home_q1')->nullable();
            $table->integer('home_q2')->nullable();
            $table->integer('home_q3')->nullable();
            $table->integer('home_q4')->nullable();
            $table->integer('home_ot1')->nullable();
            $table->integer('home_ot2')->nullable();
            $table->integer('home_ot3')->nullable();
            $table->integer('home_timeouts_remaining')->nullable();
            $table->boolean('home_in_bonus')->nullable();
            $table->integer('away_q1')->nullable();
            $table->integer('away_q2')->nullable();
            $table->integer('away_q3')->nullable();
            $table->integer('away_q4')->nullable();
            $table->integer('away_ot1')->nullable();
            $table->integer('away_ot2')->nullable();
            $table->integer('away_ot3')->nullable();
            $table->integer('away_timeouts_remaining')->nullable();
            $table->boolean('away_in_bonus')->nullable();
            $table->unsignedBigInteger('home_team_id');
            $table->unsignedBigInteger('away_team_id');
            $table->timestamps();

            $table->foreign('home_team_id')->references('team_id')->on('teams')->onDelete('cascade');
            $table->foreign('away_team_id')->references('team_id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
