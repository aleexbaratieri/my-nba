<?php

namespace App\Repositories\Contracts;

use App\Data\PlayerData;
use App\Models\Player;
use Ramsey\Uuid\UuidInterface as Uuid;

interface PlayerRepositoryInterface extends BaseRepositoryInterface
{
    public function create(PlayerData $data): Player;
    public function createOrUpdate(PlayerData $data): Player;
    public function updateById(Uuid $id, PlayerData $data): Player;
}