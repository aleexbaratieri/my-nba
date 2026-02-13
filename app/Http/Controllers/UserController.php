<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    protected $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    public function index()
    {
        return UserResource::collection(
            $this->users->getAll()
        );
    }

    public function show(string $id)
    {
        return new UserResource(
            $this->users->findById(
                Uuid::fromString($id)
            )
        );
    }
}
