<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Não autenticado'
            ], Response::HTTP_UNAUTHORIZED);
        }

        if (!$user->hasPermissionTo($permission)) {
            return response()->json([
                'message' => 'Sem permissão para acessar este recurso'
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
