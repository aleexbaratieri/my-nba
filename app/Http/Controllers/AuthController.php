<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {

            $credentials = $request->validated();

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Credenciais inválidas'
                ], Response::HTTP_UNAUTHORIZED);
            }

            $user = $request->user();

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
        return response()->json([], Response::HTTP_ACCEPTED);
    }

    public function me()
    {
        return UserResource::make(
            Auth::user()
        );
    }
}