<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HoaAdminMiddleware
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
        if(!auth()->check() || !auth()->user()->hoa_admin || !auth()->user()->hoa_admin && !auth()->user()->hoa_member){
            abort(403);
        }
        return $next($request);
    }
}
