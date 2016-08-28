<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ApiController extends Controller
{
    

    public function partnersposes(Request $request, $partner_id){
    	$partner_id=explode(",", $partner_id); // ako je stiglo više partnera npr /partnersposes/1,2,3
    	$poses = \App\Models\Pos::whereIn('partner_id',$partner_id)->orderBy('name')->get();
		return response()->json($poses);
    }

    public function posusers(Request $request, $pos_id){
    	$pos_id=explode(",", $pos_id); // ako je stiglo više poseva npr /posusers/1,2,3
    	$users = \App\Models\User::withTrashed()->whereIn('pos_id',$pos_id)->orderBy('name')->get();
		return response()->json($users);
    }


}
