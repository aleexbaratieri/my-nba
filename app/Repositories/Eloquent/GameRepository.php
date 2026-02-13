<?php

namespace App\Repositories\Eloquent;

use App\Data\GameData;
use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use Ramsey\Uuid\UuidInterface as Uuid;

class GameRepository extends BaseRepository implements GameRepositoryInterface
{
    public function __construct(Game $model)
    {
        $this->model = $model;
    }

    public function create(GameData $data): Game
    {
        $game = $this->model->create($data->toArray());
        return $game->load(['homeTeam', 'awayTeam']);
    }

    public function createOrUpdate(GameData $data): Game
    {
        $game = $this->model->updateOrCreate(['game_id' => $data->game_id], $data->toArray());
        return $game->load(['homeTeam', 'awayTeam']);
    }

    public function updateById(Uuid $id, GameData $data): Game
    {
        $game = $this->findById($id);
        $game->update($data->toArray());
        return $game->load(['homeTeam', 'awayTeam']);
    }
}