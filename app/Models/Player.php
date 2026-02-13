<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'players';

    protected $fillable = [
        'player_id',
        'first_name',
        'last_name',
        'position',
        'height',
        'weight',
        'jersey_number',
        'college',
        'country',
        'draft_year',
        'draft_round',
        'draft_number',
        'team_id',
    ];

    protected $casts = [
        'player_id' => 'integer',
        'weight' => 'integer',
        'draft_year' => 'integer',
        'draft_round' => 'integer',
        'draft_number' => 'integer',
        'team_id' => 'integer',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'team_id');
    }
}
