<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class StatsController extends Controller
{
    

    public function index()
    {
    	return view('stats.home');
    }


}
