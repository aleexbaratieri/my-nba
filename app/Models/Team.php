<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'teams';

    protected $fillable = [
        'team_id',
        'conference',
        'division',
        'city',
        'name',
        'full_name',
        'abbreviation',
    ];

    protected $casts = [
        'team_id' => 'integer',
    ];
}
