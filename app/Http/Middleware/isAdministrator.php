<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class isAdministrator {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::check()) {
            if (Auth::user()->admin == true) {
                return $next($request);
            }
        }
        return redirect()->route('home');
    }
}
