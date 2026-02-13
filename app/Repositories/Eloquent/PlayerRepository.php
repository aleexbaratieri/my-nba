<?php

namespace App\Repositories\Eloquent;

use App\Data\PlayerData;
use App\Models\Player;
use App\Repositories\Contracts\PlayerRepositoryInterface;
use Ramsey\Uuid\UuidInterface as Uuid;

class PlayerRepository extends BaseRepository implements PlayerRepositoryInterface
{
    public function __construct(Player $model)
    {
        $this->model = $model;
    }

    public function create(PlayerData $data): Player
    {
        $player = $this->model->create($data->toArray());
        return $player->load('team');
    }

    public function createOrUpdate(PlayerData $data): Player
    {
        $player = $this->model->updateOrCreate(['player_id' => $data->player_id], $data->toArray());
        return $player->load('team');
    }

    public function updateById(Uuid $id, PlayerData $data): Player
    {
        $player = $this->findById($id);
        $player->update($data->toArray());
        return $player->load('team');
    }
}