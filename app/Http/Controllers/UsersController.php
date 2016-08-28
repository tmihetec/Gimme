<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth, Validator;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // da li user može hendlati korisnike?
       // nevalja 
       $this->middleware('isAdmin:CRUDusers', ['only'=>[
                    'index',
                    'create',
                    'edit',
                    'delete',
                    'recalculateAllResults',
                    'store',
                    'adminUpdate'
                ]]);
       $this->middleware('adminOrOwner:userModel', ['only'=>[
                    'update',
                    'show',
                    'recalculateResults'
                ]]);

    }

    /**
     * Show the users list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $editOrCreateUser=null, $createnew=false)
    {

        $currentuserroles = null;
        $rolelist=null;
        $poslist=null;

        if ($editOrCreateUser || $createnew) {
            $rolelist = \App\Models\Role::pluck('name','id');

            /* TEMP */

            $poslist = \App\Models\Pos::get()->pluck('full_name','id');//with('parent')->get();
            if ($editOrCreateUser) {
                $currentuserroles=$editOrCreateUser->roles->pluck('id')->toArray();
            } 
        } 


        $users=\App\Models\User::withTrashed()->with('roles')->get();

        $sendData=[
            'users'=>$users,
            'rolelist' => $rolelist,
            'poslist'=>$poslist,
            'editOrCreateUser' => $editOrCreateUser,
            'createnew'=> $createnew,
            'currentuserroles'=>$currentuserroles,
        ];
        return view('users.index')->with($sendData);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {

        return $this->index($request, new \App\Models\User, true);
    }

    /**
     * Show the form for editing a resource.
     *
     */
    public function edit(Request $request, $user)
    {
        $editOrCreateUser=\App\Models\User::with('roles')->withTrashed()->where('id','=',$user)->first();
        return $this->index($request, $editOrCreateUser, false);
    }


    /**
     * Show user data.
     *
     */
    public function show(\App\Models\User $user)
    {

        $sendData=[
            'user'=>$user,
        ];
        return view('users.details')->with($sendData);
    }


    /**
     * Store new user data.
     *
     */
    public function store(Request $request)
    {


        $rules= [
            'nickname' => 'required|min:3',
            'email' => 'required|email',   
            'newpass' => 'sometimes|min:6',
        ];
        

        $messages = [
            'nickname.required' => 'Nickname cannot be empty! Pls name user with at least 3 characters.',
            'nickname.min' => 'Nickname too short! Please name user with at least 3 characters.',
            'email.required' => 'You must enter email for user, as that is their login.',
            'email.email' => 'Something is wrong with email format',
            'newpass.min' => 'New password too short',
        ];


        $this->validate($request,$rules,$messages);

        // spremi podatke za korisnika...
        // da li možda treba dodatna validacija (ono ponovo, admin pass?)


        $user = new \App\Models\User;        
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->name = $request->nickname;
        $user->email = $request->email;
        $user->pos_id = ($request->pos=="") ? null : $request->pos;
        //pass
        if ($request->newpass) {
            $user->password = \Hash::make($request->newpass);
        }
        //active        
        $user->affiliateActive = $request->activeuser;

        $user->save();

        //roles
        //-------------------------------------------------------------------
        // ako user nije "superadmin", onda nemože spremiti Rolu "superadmin"
        // temp:
        $saroleid= (\App\Models\Role::where('name','=','superadmin')->exists()) 
            ? \App\Models\Role::where('name','=','superadmin')->first()->id
            : 0;
        $roles= $request->userroles;
        if (\Auth::user()->isNot('superadmin')) {
            foreach($roles as $k=>$roleid){
                if ($roleid == $saroleid) {
                        $roles=array_except($roles,[$k]);
                        break; 
                }
            }
        }
        //-------------------------------------------------------------------

        $user->roles()->sync( (array) $roles );


        //deleted
        if ($request->deleteduser == 1) {
            $user->delete();
        } else if ($user->trashed()) {
            $user->restore();
        }
                
        $request->session()->flash('message', 'New user created!');
        return redirect('users');

    }


    /**
     * Update user data.
     *
     */
    public function adminUpdate(Request $request, $user)
    {


        $user=\App\Models\User::withTrashed()->find($user);        

        // ako je user "superadmin", onda mu password, email i roles može promijeniti samo "superadmin" 
        if ($user->is('superadmin') && \Auth::user()->isNot('superadmin')) {
            return redirect('users')->withErrors("Superadmin user data not saved - unauthorised user.");
        }



        $rules= [
            'nickname' => 'required|min:3',
            'email' => 'required|email',   
            'newpass' => 'sometimes|min:6',
        ];
        

        $messages = [
            'nickname.required' => 'Nickname cannot be empty! Pls name user with at least 3 characters.',
            'nickname.min' => 'Nickname too short! Please name user with at least 3 characters.',
            'email.required' => 'You must enter email for user, as that is their login.',
            'email.email' => 'Something is wrong with email format',
            'newpass.min' => 'New password too short',
        ];


        $this->validate($request,$rules,$messages);


        // spremi podatke za korisnika...
        // da li možda treba dodatna validacija (ono ponovo, admin pass?)


        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->name = $request->nickname;
        $user->pos_id = ($request->pos=="") ? null : $request->pos;

        $user->email = $request->email;
        //pass
        if ($request->newpass) {            
            $user->password = \Hash::make($request->newpass);
        }

        //roles
        $user->roles()->sync( (array) $request->userroles );

        //active        
        $user->affiliateActive = $request->activeuser;

        $user->save();

        //deleted
        if ($request->deleteduser == 1) {
            $user->delete();
        } else if ($user->trashed()) {
            $user->restore();
        }
                
        $request->session()->flash('message', 'User data saved!');

        return redirect('users');
        //return $this->index($request);

    }



    /**
     * Update user data, user input.
     *
     */
    public function update(\App\Http\Requests\UpdateUserDetails $request, \App\Models\User $user)
    {



        // ako je user "superadmin", onda mu password, email i roles može promijeniti samo "superadmin" 
        if ($user->is('superadmin') && \Auth::user()->isNot('superadmin')) {
            return redirect('users')->withErrors("Superadmin user data not saved - unauthorised user.");
        }


        // validacija u REQUESTU

        $user->firstname = $request->input("firstname");
        $user->lastname = $request->input("lastname");
        $user->name = $request->input("nickname");

        $poruka=false;

        if($request->input("changepass")==1)
        {

            
            // provjeri jel OLD pass kak spada
            //if (\Hash::check($request->input('oldpass'), $user->getAuthPassword())) 
            if (Auth::validate(['email'=>$request->input('email'), 'password'=>$request->input('oldpass')])) 
            { 
                // update pass info u bazu
                $user->password = \Hash::make($request->input('newpass'));          
            } else {
                $poruka = "Old password not matching our records!";
            }
        }

        if (!$poruka) {
            $user->save();  
            $poruka='User data saved!';                      
        } 

        $sendData=[
            'message'=>$poruka,
            'user'=>$user,
        ];

        return redirect('affiliate/'.$user->id)->with($sendData);
        //return view('users.details')->with($sendData);
    }




    // post save scrapbook
    public function saveScrapBook(Request $request)
    {

        $this->validate($request,array(
            //'content'=>'required'
            ));

        $user=Auth::user();

        $user->scrapbook=$request->content;
        $user->save();
        
        // ajax?
        if($request->ajax()){

            return response()->json(array(
                    'success' => true,
            ), 200);

        }

        // obični
        return back()->with('message', 'Saved');

    }

    

    public function recalculateAllResults(){

        // user results
        $users=\App\Models\User::withTrashed()->get();//all();
        foreach($users as $user)
        {
            $this->recalculateResults($user);
        }


        // pos results
        $poses=\App\Models\Pos::all();
        foreach($poses as $pos)
        {
            $pos->resultc = $pos->users->sum('resultc');            
            $pos->resultm = $pos->users->sum('resultm');            
            $pos->resultq = $pos->users->sum('resultq');            
            $pos->resultw = $pos->users->sum('resultw');            
            $pos->save();
        }


        // partner results
        $partners=\App\Models\Partner::all();
        foreach($partners as $partner)
        {
            $partner->resultc = $partner->poses->sum('resultc');            
            $partner->resultm = $partner->poses->sum('resultm');            
            $partner->resultq = $partner->poses->sum('resultq');            
            $partner->resultw = $partner->poses->sum('resultw');            
            $partner->save();
        }

        //return redirect('users');//->with('message','Recalculated!');
        return back()->with('message','Recalculated!');
    }



    public function recalculateResults($user){

        $user->resultc = $user->items()->get()->sum('pivot.points');  
        $user->resultq = $user->items()->where('date','>=',\Carbon\Carbon::now()->firstOfQuarter()->format('Y-m-d'))->get()->sum('pivot.points');
        $user->resultm = $user->items()->where('date','>=',\Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d'))->get()->sum('pivot.points');
        $user->resultw = $user->items()->where('date','>=',\Carbon\Carbon::now()->startOfWeek()->format('Y-m-d'))->get()->sum('pivot.points');

        $user->save();
        return true;
    }



    // post, add score to user
    public function addScore(Request $request){


        // provjeriti da li je trenutni user = auth::useru!
        $validation_rules=array(
                'user'  =>  'required',
                'points'=>  'required|numeric',
                'itemid'=>  'required|numeric',
                'date'  =>  'required|date',
                'invoice'=> 'required'

            );
        $validation_messages=array();
        $validator = Validator::make($request->all(),$validation_rules,$validation_messages);

        $errors = array();

        $item = \App\Models\Item::findOrFail($request->input('itemid'));

        // vidi da li prolazi validaciju i da li je aktivan item?
        if ($validator->fails() || !$item->aktivan)
        {


            if ($validator->fails())
            {                
                array_push($errors,$validator->getMessageBag()->toArray());
            }
            if (!$item->aktivan)
            {                
                array_push($errors,"item not available");
            }



            if($request->ajax()){

                // vrati bad ajax resp
                return response()->json(array(
                    'success' => false,
                    'errors' => $errors

                ), 400); // 400 being the HTTP code for an invalid request.

            } else {
                // normalni submit (v2)
                return back()->withInput();
            }

        } else {
        // prošlo validaciju i aktivan je item

                $userid = $request->input('user');
                $points = $request->input('points');
                $itemid = $request->input('itemid');
                $date   = date("Y-m-d", strtotime($request->input('date')));
                $invoice= $request->input('invoice');

                $when=false;
                $lame_week=false;

                // dodaj u users tablicu ove points u sve 3 kolone
                $user=Auth::user();
                // ovaj tjedan?
                if($date >= \Carbon\Carbon::now()->startOfWeek()->format("Y-m-d")) {
                    $user->resultw= $user->resultw+$points;
                    $lame_week=true;
                }
                // da li je date u ovom mjesecu?
                if($date >= \Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d')) {
                    $user->resultm=$user->resultm+$points;
                    $user->resultq=$user->resultq+$points;
                    $when='this_month';
                } else if ($date >= \Carbon\Carbon::now()->firstOfQuarter()->format('Y-m-d')) {
                    // ako nije, da li je date u ovom mjesecu?                
                    $user->resultq=$user->resultq+$points;
                    $when='this_quarter';
                }

                $user->resultc=$user->resultc+$points;


                // dodaj i na rezultat njegovog POS-a
                if ($user->pos){
                    if($lame_week) {
                        $user->pos->resultw += $points;                    
                    }
                    if ($when=='this_month') {
                        $user->pos->resultm += $points;                    
                        $user->pos->resultq += $points;                    
                    } elseif ($when=='this_quarter') {
                        $user->pos->resultq += $points;                    
                    }
                    $user->pos->resultc += $points;                    
                }


                // dodaj i na rezultat njegovog POS PARENTA (Partnera)
                if ($user->pos && $user->pos->partner){
                    if($lame_week) {
                        $user->pos->partner->resultw += $points;                    
                    }
                    if ($when=='this_month') {
                        $user->pos->partner->resultm += $points;                    
                        $user->pos->partner->resultq += $points;                    
                    } elseif ($when=='this_quarter') {
                        $user->pos->partner->resultq += $points;                    
                    }
                    $user->pos->partner->resultc += $points;                    
                }
                

                $user->save();
                // dodaj u realisation tablicu detalje
                // https://laravel.com/docs/master/eloquent-relationships
                $user->items()->attach($itemid, ['points'=>$points,'date'=>$date, 'invoice'=>$invoice]);

                if($request->ajax()){
        
                    return response()->json(array(
                            'success' => true,
                            'newm'=> $user->resultm,
                            'newq'=> $user->resultq,
                            'newc'=> $user->resultc
                    ), 200);

                } else {
                    // normalni submit (v2)
                    return view('/');
                }

        }

           
        
    }



}
