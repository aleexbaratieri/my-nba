<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class GameData extends Data
{
    public function __construct(
        #[Required]
        public int $game_id,
        #[Required]
        public string $date,
        #[Required]
        public int $season,
        #[Required]
        public string $status,
        public Optional|int|null $period,
        public Optional|string|null $time,
        public Optional|bool|null $postseason,
        public Optional|bool|null $postponed,
        public Optional|int|null $home_team_score,
        public Optional|int|null $away_team_score,
        public Optional|string|null $datetime,
        public Optional|int|null $home_q1,
        public Optional|int|null $home_q2,
        public Optional|int|null $home_q3,
        public Optional|int|null $home_q4,
        public Optional|int|null $home_ot1,
        public Optional|int|null $home_ot2,
        public Optional|int|null $home_ot3,
        public Optional|int|null $home_timeouts_remaining,
        public Optional|bool|null $home_in_bonus,
        public Optional|int|null $away_q1,
        public Optional|int|null $away_q2,
        public Optional|int|null $away_q3,
        public Optional|int|null $away_q4,
        public Optional|int|null $away_ot1,
        public Optional|int|null $away_ot2,        
        public Optional|int|null $away_ot3,
        public Optional|int|null $away_timeouts_remaining,
        public Optional|bool|null $away_in_bonus,
        #[Required]
        public int $home_team_id,
        #[Required]
        public int $away_team_id
    ) {}
}
