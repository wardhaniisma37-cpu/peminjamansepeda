<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;
        
        // Cek apakah role user sesuai
        if (in_array($userRole, $roles)) {
            return $next($request);
        }
        
        // Jika tidak punya akses
        abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
    }
}