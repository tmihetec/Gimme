<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth,Lava;

class RealisationController extends Controller
{
    public function __construct()
    {
       $this->middleware('adminOrOwner:userItem', ['only'=>[
                    'destroyItem',
                ]]);
       $this->middleware('isAdmin', ['only'=>[
                    'realisationForUserInPeriod',
                ]]);

    }


    public function realisationForUserInPeriod(Request $request, $user=null, $period=null)
    {
        $affiliate = \App\Models\User::findOrFail($user);
        // carbon, current date
        $currentDate=\Carbon\Carbon::now();
        // inače vrati prikaz detalja za period
        if($period=='m'){
            $panelTitle="This month's details for ";
            $details = $affiliate->items()->where('date','>=',$currentDate->firstOfMonth()->format("Y-m-d"))->get();
        } else if ($period=='q') {
            $panelTitle="This quarter's details for ";
            $details = $affiliate->items()->where('date','>=',$currentDate->firstOfQuarter()->format("Y-m-d"))->get();
        } else { // onda je valjda 'c'
            $panelTitle="Complete details for ";
            $details = $affiliate->items()->get();
        }

        $sendData=[
            'affiliate'=>$affiliate,
            'panelTitle'=>$panelTitle,
            'details'=>$details,
        ];
        return view('realisation.periodForUser')->with($sendData);
    }

    //
    public function index(Request $request, $period = null){


		//RECALCULATE RESULTS FOR USER!
		//\App\Http\Controllers\UsersController::recalculateResults(Auth::user());
        $affiliate = Auth::user();

    	if(!$period) {return $this->dash($request,$affiliate);}

    	// carbon, current date
    	$currentDate=\Carbon\Carbon::now();

		// inače vrati prikaz detalja za period
		if($period=='m'){
			$panelTitle="This month's details for ";
			$details = $affiliate->items()->where('date','>=',$currentDate->firstOfMonth()->format("Y-m-d"))->get();
		} else if ($period=='q') {
			$panelTitle="This quarter's details for ";
			$details = $affiliate->items()->where('date','>=',$currentDate->firstOfQuarter()->format("Y-m-d"))->get();
		} else { // onda je valjda 'c'
			$panelTitle="Complete details for ";
			$details = $affiliate->items()->get();
		}

		$sendData=[
			'affiliate'=>$affiliate,
			'panelTitle'=>$panelTitle,
			'details'=>$details,
		];

    	return view('realisation.period')->with($sendData);
		dd($period);    	
    }

    public function destroyItem(Request $request, $id)
    {
    	$message=null;
    	$item = null;
    	$deleted = false;
    	$value=0;
    	$newm=0;
    	$newq=0;
    	$newc=0;

    	// ako može sve brisati, onda vidi samo jel locked
    	if (Auth::user()->can("deleteAllUnlockedRealisations")) {
    		$item=\App\Models\Realisation::where('id','=',$id)->first();
    	} else {
    		// samo svoje može brisati    		
    		$item=\App\Models\Realisation::where('user_id','=',Auth::id())->where('id','=',$id)->first();
    	}

    	// ako postoji taj row
		if($item) {


			if($item->locked==1) {
				$message="Can't delete, item locked!";
			} else {
    			$item->delete();
				$message="Item deleted!";
				$deleted=true;
				// koja je to vrijednost?
				$points=$item->points;
				$user=\App\Models\User::find($item->user_id);
				$date=$item->date;


                // ovaj tjedan?
                if($date >= \Carbon\Carbon::now()->startOfWeek()->format("Y-m-d")) {
                    $user->resultw= ($user->resultw-$points <= 0) ? 0 : $user->resultw-$points;
                }
				// da li je date u ovom mjesecu?
                if($date >= \Carbon\Carbon::now()->firstOfMonth()->format("Y-m-d")) {
                    $user->resultm= ($user->resultm-$points <= 0) ? 0 : $user->resultm-$points;
                    $user->resultq= ($user->resultq-$points <= 0) ? 0 : $user->resultq-$points;
                } else if ($date >= \Carbon\Carbon::now()->firstOfQuarter()->format("Y-m-d")) {
                    // ako nije, da li je date u ovom mjesecu?                
                    $user->resultq= ($user->resultq-$points <= 0) ? 0 : $user->resultq-$points;
                }
                //u svakom slučaju smanji ukupno...
                $user->resultc= ($user->resultc-$points <= 0) ? 0 : $user->resultc-$points;

				$user->save();

				$newm = $user->resultm;
				$newq = $user->resultq;
				$newc = $user->resultc;

			}
		} else {
			$message = "Operation not allowed, item doesn't exists!";
		}

    	if ($request->ajax()){


	        return response()->json(array(
    	                    'success' => true,
        	                'message'=> $message,
        	                'deleted'=> $deleted,
        	                'newm'=> $newm,
        	                'newq'=> $newq,
        	                'newc'=> $newc,
            	    ), 200); // 400 ako nije uspio... bad request
    	
    	} else {
	    	return back()->with('message',$message);
		}

    }


    public function dash($request,$affiliate)
   	{
    	$topfive = $affiliate->topitems->sortByDesc('total')->slice(0,5);
        $topsellers = $affiliate->pos->partner->users->sortByDesc('resultm');
        $topposes = $affiliate->pos->partner->poses->sortByDesc('resultm');
    	$weeksales = $affiliate->weeksales->sortBy('week');

    	//http://lavacharts.com/#datatables
    	$graf = Lava::DataTable()
    		->addStringColumn('week')
            ->addNumberColumn('pts')
            ->addNumberColumn('qty');

	    foreach($weeksales as $weeksale)
	    {
	        $rowData = [
	          "W".$weeksale->week, $weeksale->total, $weeksale->qty
	        ];

	        $graf->addRow($rowData);
	    }
		Lava::LineChart('WeekPoints', $graf, [
                'title' => 'Pts gained over weeks',
                'height' => 241
                ]);

		$sendData=[
			'affiliate'=>$affiliate,
			'topfive'=>$topfive,
            'topsellers'=>$topsellers,
            'topposes'=>$topposes,
			'counter'=>1
		];

    	return view('realisation.index')->with($sendData);
    }

}
