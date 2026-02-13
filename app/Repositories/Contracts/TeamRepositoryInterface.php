<?php

namespace App\Repositories\Contracts;

use App\Data\TeamData;
use App\Models\Team;
use Ramsey\Uuid\UuidInterface as Uuid;

interface TeamRepositoryInterface extends BaseRepositoryInterface
{
    public function create(TeamData $data): Team;
    public function createOrUpdate(TeamData $data): Team;
    public function updateById(Uuid $id, TeamData $data): Team;
}