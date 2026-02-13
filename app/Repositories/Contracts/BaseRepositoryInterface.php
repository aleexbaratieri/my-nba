<?php

namespace App\Repositories\Contracts;

use App\Repositories\Constants\Pagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\UuidInterface as Uuid;

interface BaseRepositoryInterface
{
    public function getAll(int $perPage = Pagination::PER_PAGE, array $relations = []): LengthAwarePaginator;
    public function findById(Uuid $id, array $relations = []): Model;
    public function deleteById(Uuid $id): void;
}