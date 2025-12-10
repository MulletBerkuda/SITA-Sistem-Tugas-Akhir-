<?php 

namespace App\Http\Middleware;

use Closure;

class CheckToken
{
    public function handle($request, Closure $next, $role)
    {
        $token = $request->bearerToken();

        // Jika tidak ada token — API harus balikan JSON, bukan redirect
        if (!$token) {
            return response()->json([
                'message' => 'Unauthenticated. Token missing'
            ], 401);
        }

        // Cek token Sanctum
        $user = \Laravel\Sanctum\PersonalAccessToken::findToken($token)?->tokenable;

        if (!$user) {
            return response()->json([
                'message' => 'Invalid token'
            ], 401);
        }

        // Cek role
        if ($user->role !== $role) {
            return response()->json([
                'message' => 'Unauthorized role'
            ], 403);
        }

        // Menyisipkan user valid ke request
        $request->merge(['user' => $user]);

        return $next($request);
    }
}
