<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PlayerData extends Data
{
    public function __construct(
        #[Required]
        public int $player_id,
        #[Required]
        public string $first_name,
        #[Required]
        public string $last_name,
        public Optional|string $position,
        public Optional|string $height,
        public Optional|int $weight,
        public Optional|int $jersey_number,
        public Optional|string $college,
        public Optional|string $country,
        public Optional|int $draft_year,
        public Optional|int $draft_round,
        public Optional|int $draft_number,
        #[Required]
        public int $team_id
    ) {}
}