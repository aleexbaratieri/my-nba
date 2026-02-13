<?php

namespace App\Http\Controllers;

use App\Data\TeamData;
use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamResource;
use App\Repositories\Contracts\TeamRepositoryInterface;
use Ramsey\Uuid\Uuid;

class TeamController extends Controller
{
    protected $teams;

    protected int $perPage = 10;

    public function __construct(TeamRepositoryInterface $teams)
    {
        $this->teams = $teams;

        if (request()->has('per_page')) {
            $this->perPage = request('per_page');
        }
    }

    public function index()
    {
        return TeamResource::collection(
            $this->teams->getAll()
        );
    }

    public function show(string $id)
    {
        return TeamResource::make(
            $this->teams->findById(
                Uuid::fromString($id)
            )
        );
    }

    public function store(TeamRequest $request)
    {
        return TeamResource::make(
            $this->teams->create(
                TeamData::from($request->validated())
            )
        );
    }

    public function update(TeamRequest $request, string $id)
    {
        return TeamResource::make(
            $this->teams->updateById(
                Uuid::fromString($id),
                TeamData::from($request->validated())
            )
        );
    }

    public function destroy(string $id)
    {
        $this->teams->deleteById(
            Uuid::fromString($id)
        );

        return response()->noContent();
    }
}
