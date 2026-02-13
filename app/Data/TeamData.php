<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class TeamData extends Data
{
    public function __construct(
        #[Required]
        public int $team_id,
        public Optional|string|null $conference,
        public Optional|string|null $division,
        public Optional|string|null $city,
        #[Required]
        public string $name,
        #[Required]
        public string $full_name,
        public Optional|string|null $abbreviation    
    ) {}
}