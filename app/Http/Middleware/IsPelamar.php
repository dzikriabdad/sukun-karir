<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsPelamar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (Auth::check()) {
            // 2. Jika perannya adalah 'admin', arahkan ke wilayah admin
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.applications.index')
                                 ->with('error', 'Akses ditolak! Admin tidak boleh mengakses halaman pelamar.');
            }
        }

        // 3. Jika perannya adalah 'pelamar' (atau belum login), izinkan lanjut
        return $next($request);
    }
}