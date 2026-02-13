<?php

namespace App\Repositories\Contracts;

use App\Data\UserData;
use App\Models\User;
use Ramsey\Uuid\UuidInterface as Uuid;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function create(UserData $data): User;
    public function updateById(Uuid $id, UserData $data): User;
}