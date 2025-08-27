<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {

        // try {
        //     $user = $request->user();
        //     $userRole = $user->roles->pluck('role')->toArray();

        //     foreach ($role as $r) {
        //         if (in_array($r, $userRole)) {
        //             return $next($request);
        //         }
        //     }

        //     return response()->json(['message' => 'Acceso no autorizado'], 403);
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Error al verificar el rol', 'error' => $e->getMessage()], 500);
        // }

        try {
            $user = $request->user();
            $userRole = $user->roles->pluck('role')->toArray();

            foreach ($role as $r) {
                if (in_array($r, $userRole)) {
                    return $next($request);
                }
            }

            return response()->json(['message' => 'Acceso no autorizado'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al verificar el rol', 'error' => $e->getMessage()], 500);
        }

        

        return $next($request);
    }
}
