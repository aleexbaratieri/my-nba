<?php

namespace App\Jobs;

use App\Data\TeamData;
use App\Repositories\Eloquent\TeamRepository;
use App\Traits\EmptyString;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportTeamsToDatabaseJob implements ShouldQueue
{
    use Queueable, EmptyString;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $teams)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(TeamRepository $repo): void
    {
        logger('Importando times');

        if (isset($this->teams['data']) && !empty($this->teams['data'])) {
            foreach ($this->teams['data'] as &$team) {
                $repo->create(
                    new TeamData(
                        team_id: $team['id'],
                        conference: $this->isEmptyString($team['conference']) ? null : $team['conference'],
                        division: $this->isEmptyString($team['division']) ? null : $team['division'],
                        city: $this->isEmptyString($team['city']) ? null : $team['city'],
                        name: $team['name'],
                        full_name: $team['full_name'],
                        abbreviation: $this->isEmptyString($team['abbreviation']) ? null : $team['abbreviation']
                    )
                );
            }
        }

        logger('Times importados com sucesso');
    }
}
