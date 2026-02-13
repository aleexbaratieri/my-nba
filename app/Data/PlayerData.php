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
        public Optional|string|null $position,
        public Optional|string|null $height,
        public Optional|int|null $weight,
        public Optional|int|null $jersey_number,
        public Optional|string|null $college,
        public Optional|string|null $country,
        public Optional|int|null $draft_year,
        public Optional|int|null $draft_round,
        public Optional|int|null $draft_number,
        #[Required]
        public int $team_id
    ) {}
}