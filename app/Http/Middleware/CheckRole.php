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

        if (isset($user->is_active) && !$user->is_active) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('patient.login')->withErrors([
                'login' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ Quản trị viên.',
            ]);
        }

        $userRole = $user->role ? strtolower(trim($user->role->name)) : null;
        $allowedRoles = array_map('strtolower', array_map('trim', $roles));

        if (!$userRole || !in_array($userRole, $allowedRoles, true)) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}
