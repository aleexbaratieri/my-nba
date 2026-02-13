<?php

namespace App\Repositories\Contracts;

use App\Data\GameData;
use App\Models\Game;
use Ramsey\Uuid\UuidInterface as Uuid;

interface GameRepositoryInterface extends BaseRepositoryInterface
{
    public function create(GameData $data): Game;
    public function createOrUpdate(GameData $data): Game;
    public function updateById(Uuid $id, GameData $data): Game;
}