<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Memeriksa apakah pengguna telah login
        if (auth()->check()) {
            $roleUserId = auth()->user()->role_user_id;

            // Memeriksa apakah role_user_id antara 1 dan 2
            if ($roleUserId == 1) {
                return $next($request);
            }

            // Jika role_user_id tidak valid, Anda dapat mengarahkan pengguna ke halaman tertentu atau memberikan respons lainnya.
            return redirect('/');
        }

        return redirect()->route('login');
    }
}
