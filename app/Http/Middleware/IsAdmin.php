<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $orHasAbility=null)
    {

        if ($request->user()->is('admin') || $request->user()->is('superadmin') || $request->user()->can($orHasAbility)) {
            return $next($request);
        }

        return redirect("")->withErrors(['Not authorised to perform requested action.']);
        //return back()->withErrors(['Not authorised to perform requested action.']); - loop

    }
}
