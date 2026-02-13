<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Constants\Pagination;
use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\UuidInterface as Uuid;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function getAll(int $perPage = Pagination::PER_PAGE, array $relations = []): LengthAwarePaginator
    {
        if ($perPage > Pagination::MAX_PER_PAGE) {
            $perPage = Pagination::MAX_PER_PAGE;
        }

        if ($perPage < Pagination::MIN_PER_PAGE) {
            $perPage = Pagination::MIN_PER_PAGE;
        }

        if (count($relations) > 0) {
            $this->setRelations($relations);
        }

        return $this->model->paginate($perPage);
    }

    public function findById(Uuid $id, array $relations = []): Model
    {
        if (count($relations) > 0) {
            $this->setRelations($relations);
        }
        
        return $this->model->findOrFail($id);
    }

    public function deleteById(Uuid $id): void
    {
        $user = $this->findById($id);
        $user->delete();
    }

    protected function setRelations(array $relations): void
    {
        $this->model = $this->model->with($relations);
    }
}