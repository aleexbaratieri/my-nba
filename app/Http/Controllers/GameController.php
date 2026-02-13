<?php

namespace App\Http\Controllers;

use App\Data\GameData;
use App\Http\Requests\GameRequest;
use App\Http\Resources\GameResource;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class GameController extends Controller
{
    protected $games;

    protected int $perPage = 10;

    protected array $relations = [];

    public function __construct(GameRepositoryInterface $games)
    {
        $this->games = $games;

        if (request()->has('per_page')) {
            $this->perPage = request('per_page');
        }

        if (request()->has('with_teams')) {
            if (filter_var(request('with_teams'), FILTER_VALIDATE_BOOLEAN)) {
                $this->relations[] = 'homeTeam';
                $this->relations[] = 'awayTeam';
            }
        }
    }

    public function index()
    {
        return GameResource::collection(
            $this->games->getAll(
                perPage: $this->perPage,
                relations: $this->relations
            )
        );
    }

    public function show(string $id)
    {
        return GameResource::make(
            $this->games->findById(
                id: Uuid::fromString($id),
                relations: $this->relations
            )
        );
    }

    public function store(GameRequest $request)
    {
        return GameResource::make(
            $this->games->create(
                GameData::from($request->validated())
            )
        );
    }

    
    public function update(Request $request, string $id)
    {
        return GameResource::make(
            $this->games->updateById(
                Uuid::fromString($id),
                GameData::from($request->validated())
            )
        );
    }

    public function destroy(string $id)
    {
        $this->games->deleteById(
            Uuid::fromString($id)
        );

        return response()->noContent();
    }
}
