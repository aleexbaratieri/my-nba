<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'games';

    protected $fillable = [
        'game_id',
        'date',
        'season',
        'status',
        'period',
        'time',
        'postseason',
        'postponed',
        'home_team_score',
        'away_team_score',
        'datetime',
        'home_q1',
        'home_q2',
        'home_q3',
        'home_q4',
        'home_ot1',
        'home_ot2',
        'home_ot3',
        'home_timeouts_remaining',
        'home_in_bonus',
        'away_q1',
        'away_q2',
        'away_q3',
        'away_q4',
        'away_ot1',
        'away_ot2',
        'away_ot3',
        'away_timeouts_remaining',
        'away_in_bonus',
        'home_team_id',
        'away_team_id',
    ];

    protected $casts = [
        'date' => 'date',
        'season' => 'integer',
        'period' => 'integer',
        'datetime' => 'datetime',
        'postseason' => 'boolean',
        'postponed' => 'boolean',
        'home_team_score' => 'integer',
        'away_team_score' => 'integer',
        'home_in_bonus' => 'boolean',
        'away_in_bonus' => 'boolean',
        'home_timeouts_remaining' => 'integer',
        'away_timeouts_remaining' => 'integer',
        'home_q1' => 'integer',
        'home_q2' => 'integer',
        'home_q3' => 'integer',
        'home_q4' => 'integer',
        'home_ot1' => 'integer',
        'home_ot2' => 'integer',
        'home_ot3' => 'integer',
        'away_q1' => 'integer',
        'away_q2' => 'integer',
        'away_q3' => 'integer',
        'away_q4' => 'integer',
        'away_ot1' => 'integer',
        'away_ot2' => 'integer',
        'away_ot3' => 'integer',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id', 'team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id', 'team_id');
    }
}
