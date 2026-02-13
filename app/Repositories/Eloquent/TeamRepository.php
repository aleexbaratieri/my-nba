<?php

namespace App\Repositories\Eloquent;

use App\Data\TeamData;
use App\Models\Team;
use App\Repositories\Contracts\TeamRepositoryInterface;
use Ramsey\Uuid\UuidInterface as Uuid;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    public function __construct(Team $model)
    {
        $this->model = $model;
    }

    public function create(TeamData $data): Team
    {
        return $this->model->create($data->toArray());
    }

    public function createOrUpdate(TeamData $data): Team
    {
        return $this->model->updateOrCreate(['team_id' => $data->team_id], $data->toArray());
    }

    public function updateById(Uuid $id, TeamData $data): Team
    {
        $team = $this->findById($id);
        $team->update($data->toArray());
        return $team;
    }
}