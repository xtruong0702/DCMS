<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
        $userRole = $user->role ? strtolower(trim($user->role->name)) : null;
        $allowedRoles = array_map('strtolower', array_map('trim', $roles));

        if (!$userRole || !in_array($userRole, $allowedRoles, true)) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}
