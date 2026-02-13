<?php

namespace App\Jobs;

use App\Data\PlayerData;
use App\Repositories\Eloquent\PlayerRepository;
use App\Traits\EmptyString;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportPlayersToDatabaseJob implements ShouldQueue
{
    use Queueable, EmptyString;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $players)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(PlayerRepository $repo): void
    {
        logger('Importando jogadores');

        if (isset($this->players['data']) && !empty($this->players['data'])) {
            foreach ($this->players['data'] as &$player) {
                try {
                    $repo->createOrUpdate(
                        new PlayerData(
                            player_id: $player['id'],
                            first_name: $player['first_name'],
                            last_name: $player['last_name'],
                            position: $this->isEmptyString($player['position']) ? null : $player['position'],
                            height: $this->isEmptyString($player['height']) ? null : $player['height'],
                            weight: is_numeric($player['weight']) ? $player['weight'] : null,
                            jersey_number: is_numeric($player['jersey_number']) ? $player['jersey_number'] : null,
                            college: $this->isEmptyString($player['college']) ? null : $player['college'],
                            country: $this->isEmptyString($player['country']) ? null : $player['country'],
                            draft_year: is_numeric($player['draft_year']) ? $player['draft_year'] : null,
                            draft_round: is_numeric($player['draft_round']) ? $player['draft_round'] : null,
                            draft_number: is_numeric($player['draft_number']) ? $player['draft_number'] : null,
                            team_id: $player['team']['id']
                        )
                    );
                } catch (\Exception) {
                    logger('Erro ao importar jogador: ' . $player);
                }
            }
        }

        logger('Jogadores importados com sucesso');
    }
}
