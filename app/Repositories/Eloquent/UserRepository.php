<?php

namespace App\Repositories\Eloquent;

use App\Data\UserData;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Ramsey\Uuid\UuidInterface as Uuid;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(UserData $data): User
    {
        return $this->model->create($data->toArray());
    }

    public function updateById(Uuid $id, UserData $data): User
    {
        $user = $this->findById($id);
        $user->update($data->toArray());
        return $user;
    }
}