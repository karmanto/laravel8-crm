<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckNonAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('home.index')->with('error', 'Anda tidak memiliki akses.');
        } else if (!auth()->check() || (auth()->check() && !auth()->user()->is_active)) {
            return redirect()->route('home.index')->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
