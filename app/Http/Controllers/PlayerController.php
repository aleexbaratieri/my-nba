<?php

namespace App\Http\Controllers;

use App\Data\PlayerData;
use App\Http\Requests\PlayerRequest;
use App\Http\Resources\PlayerResource;
use App\Repositories\Contracts\PlayerRepositoryInterface;
use Ramsey\Uuid\Uuid;

class PlayerController extends Controller
{
    protected $players;

    protected int $perPage = 10;

    protected array $relations = [];

    public function __construct(PlayerRepositoryInterface $players)
    {
        $this->players = $players;

        if (request()->has('per_page')) {
            $this->perPage = request('per_page');
        }

        if (request()->has('with_team')) {
            if (filter_var(request('with_team'), FILTER_VALIDATE_BOOLEAN)) {
                $this->relations[] = 'team';
            }
        }
    }

    public function index()
    {
        return PlayerResource::collection(
            $this->players->getAll(
                perPage: $this->perPage,
                relations: $this->relations
            )
        );
    }

    public function show(string $id)
    {
        return PlayerResource::make(
            $this->players->findById(
                id: Uuid::fromString($id),
                relations: $this->relations
            )
        );
    }

    public function store(PlayerRequest $request)
    {
        return PlayerResource::make(
            $this->players->create(
                PlayerData::from($request->validated()),
            )
        );
    }

    public function update(PlayerRequest $request, string $id)
    {
        return PlayerResource::make(
            $this->players->updateById(
                Uuid::fromString($id),
                PlayerData::from($request->validated()),
            )
        );
    }

    public function destroy(string $id)
    {
        $this->players->deleteById(
            Uuid::fromString($id)
        );

        return response()->noContent();
    }
}
