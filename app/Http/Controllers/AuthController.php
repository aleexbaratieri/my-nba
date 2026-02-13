<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected $repo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->repo = $userRepo;
    }

    public function login(LoginRequest $request)
    {
        try {

            $credentials = $request->validated();

            $user = $this->repo->findByEmail($credentials['email']);

            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                return response()->json([
                    'message' => 'Credenciais inválidas'
                ], Response::HTTP_UNAUTHORIZED);
            }

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json(
                [
                    'user' => UserResource::make($user),
                    'token' => $token,
                    'token_type' => 'Bearer', 
                ], 
                Response::HTTP_OK
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }

    public function me()
    {
        return UserResource::make(
            Auth::user()
        );
    }
}