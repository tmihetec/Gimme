<?php

namespace App\Http\Middleware;

use Closure, Bouncer;
use App\Models\Realisation;  //pivot item_user

class AdminOrOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $ownerhandler=null, $admin_role='admin', $hasAbility=null)
    {


        if($ownerhandler == 'userModel') {

            // binda se model u metodu, tak da tu dolazi objekt
            $owner_id = $request->route()->user->id;

            if ($request->user()->is('superadmin') || $request->user()->is($admin_role) || $request->user()->id == $owner_id){
                    return $next($request);
                }

        } else if($ownerhandler == 'userItem') {

            $owner_id = Realisation::find($request->route()->id)->user_id;
            if ($request->user()->is('superadmin') || $request->user()->is($admin_role) || $request->user()->id == $owner_id){
                    return $next($request);
                }

        }

        if ($request->ajax()){
            return response()->json(array(
                'success' => false,
                'message' => "Not authorised to perform requested action."
                ),200);
        }
        return redirect("")->withErrors(['Not authorised to perform requested action.']);
        //return back()->withErrors(['Not authorised to perform requested action.']);

    }
}
