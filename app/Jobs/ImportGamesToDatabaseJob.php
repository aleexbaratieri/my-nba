<?php

namespace App\Jobs;

use App\Data\GameData;
use App\Repositories\Eloquent\GameRepository;
use App\Traits\EmptyString;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportGamesToDatabaseJob implements ShouldQueue
{
    use Queueable, EmptyString;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $games)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(GameRepository $repo): void
    {
        logger('Importando jogos');

        if (isset($this->games['data']) && !empty($this->games['data'])) {
            foreach ($this->games['data'] as &$game) {
                try {
                    $repo->createOrUpdate(
                        new GameData(
                            game_id: $game['id'],
                            date: $game['date'],
                            season: $game['season'],
                            status: $this->isEmptyString($game['status']) ? null : $game['status'],
                            period: is_numeric($game['period']) ? $game['period'] : null,
                            time: $game['time'],
                            home_team_score: is_numeric($game['home_team_score']) ? $game['home_team_score'] : null,
                            away_team_score: is_numeric($game['visitor_team_score']) ? $game['visitor_team_score'] : null,
                            postseason: is_numeric($game['postseason']) ? $game['postseason'] : null,
                            postponed: is_numeric($game['postponed']) ? $game['postponed'] : null,
                            home_team_id: $game['home_team']['id'],
                            away_team_id: $game['visitor_team']['id'],
                            datetime: $game['datetime'],
                            home_q1: is_numeric($game['home_q1']) ? $game['home_q1'] : null,
                            home_q2: is_numeric($game['home_q2']) ? $game['home_q2'] : null,
                            home_q3: is_numeric($game['home_q3']) ? $game['home_q3'] : null,
                            home_q4: is_numeric($game['home_q4']) ? $game['home_q4'] : null,
                            home_ot1: is_numeric($game['home_ot1']) ? $game['home_ot1'] : null,
                            home_ot2: is_numeric($game['home_ot2']) ? $game['home_ot2'] : null,
                            home_ot3: is_numeric($game['home_ot3']) ? $game['home_ot3'] : null,
                            home_timeouts_remaining: is_numeric($game['home_timeouts_remaining']) ? $game['home_timeouts_remaining'] : null,
                            home_in_bonus: is_numeric($game['home_in_bonus']) ? $game['home_in_bonus'] : null,
                            away_q1: is_numeric($game['visitor_q1']) ? $game['visitor_q1'] : null,
                            away_q2: is_numeric($game['visitor_q2']) ? $game['visitor_q2'] : null,
                            away_q3: is_numeric($game['visitor_q3']) ? $game['visitor_q3'] : null,
                            away_q4: is_numeric($game['visitor_q4']) ? $game['visitor_q4'] : null,
                            away_ot1: is_numeric($game['visitor_ot1']) ? $game['visitor_ot1'] : null,
                            away_ot2: is_numeric($game['visitor_ot2']) ? $game['visitor_ot2'] : null,
                            away_ot3: is_numeric($game['visitor_ot3']) ? $game['visitor_ot3'] : null,
                            away_timeouts_remaining: is_numeric($game['visitor_timeouts_remaining']) ? $game['visitor_timeouts_remaining'] : null,
                            away_in_bonus: is_numeric($game['visitor_in_bonus']) ? $game['visitor_in_bonus'] : null
                        )
                    );
                } catch (\Exception) {
                    logger('Erro ao importar jogo: ' . $game);
                }
            }
        }

        logger('Jogos importados com sucesso');
    }
}
