<?php

namespace App\Console\Commands;

use App\Jobs\ImportGamesToDatabaseJob;
use App\Jobs\ImportPlayersToDatabaseJob;
use App\Jobs\ImportTeamsToDatabaseJob;
use App\Services\BallDontLieApi;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BallDontLieImport extends Command
{
    use BallDontLieApi\Traits\RetryRequest;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balldontlie:import {--season=} {--teams} {--players} {--games}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar times, jogadores e partidas do BallDontLie';

    protected int $season;

    /**
     * Execute the console command.
     */
    public function handle(BallDontLieApi\BallDontLieService $ballDontLieService)
    {
        if (! $this->hasAnyOption()) {
            $this->warn('Nenhuma opção informada.');
            return self::FAILURE;
        }

        if ($this->option('teams')) {
            $this->importTeams($ballDontLieService);
        }

        if ($this->option('players')) {
            $this->importPlayers($ballDontLieService);
        }

        if ($this->option('games')) {
            $this->importGames($ballDontLieService);
        }

        return self::SUCCESS;
    }

    protected function hasAnyOption(): bool
    {
        return $this->option('teams')
            || $this->option('players')
            || $this->option('games');
    }

    protected function importTeams(BallDontLieApi\BallDontLieService $service): void
    {
        $this->info('Importando times...');

        $teams = $this->retryRequest(
            fn () => $service->getTeams()
        );

        if (!isset($teams['data'])) {
            $this->error('Resposta inválida da API.');
            return;
        }

        ImportTeamsToDatabaseJob::dispatch($teams);

        $this->info('Job de importação de times despachado.');
    }

    protected function importPlayers(BallDontLieApi\BallDontLieService $service): void
    {
        $this->info('Importando jogadores...');

        $cursor = 0;
        $perPage = 100;

        do {
            $players = $this->retryRequest(
                fn () => $service->getPlayers(
                    cursor: $cursor,
                    perPage: $perPage
                )
            );

            if (!isset($players['data'])) {
                $this->error('Resposta inválida da API.');
                return;
            }

            ImportPlayersToDatabaseJob::dispatch($players);

            logger('Página de jogadores importada', [
                'cursor' => $cursor,
                'count'  => count($players['data']),
            ]);

            $cursor = $players['meta']['next_cursor'] ?? null;

        } while ($cursor !== null);

        $this->info('Importação de jogadores finalizada.');
    }

    protected function importGames(BallDontLieApi\BallDontLieService $service): void
    {
        $this->info('Importando jogos...');

        $maxYear = Carbon::today()->subYear()->year;

        $this->season = $this->option('season') ?? $maxYear;

        if (!is_numeric($this->season)) {
            $this->season = $maxYear;
        }

        if ($this->season > $maxYear) {
            $this->season = $maxYear;
        }

        $cursor = 0;
        $perPage = 100;

        do {
            $games = $this->retryRequest(
                fn () => $service->getGames(
                    seasons: [$this->season],
                    perPage: $perPage,
                    cursor: $cursor
                )
            );

            if (!isset($games['data'])) {
                $this->error('Resposta inválida da API.');
                return;
            }

            ImportGamesToDatabaseJob::dispatch($games);

            logger('Página de games importada', [
                'cursor' => $cursor,
                'count'  => count($games['data']),
            ]);

            $cursor = $games['meta']['next_cursor'] ?? null;

        } while ($cursor !== null);

        $this->info('Job de importação de jogos despachado.');
    }
}
