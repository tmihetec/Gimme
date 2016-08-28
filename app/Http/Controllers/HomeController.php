<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth, Lava;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }






 /**
     * action to handle streamed response from laravel
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function sse() {
        $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function() {
        $data=['test'=>1];

            while (true) {

                echo 'data: ' . json_encode($data) . "\n\n";
                ob_flush();
                flush();

                sleep(10);
            }

        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        return $response;
    }











    /**
     * Show the Admin application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex()
    {

        $partners = \App\Models\Partner::all(); 
        $poses = \App\Models\Pos::all(); 
        $items=\App\Models\Item::with('category','brand','realisationsdataw','latestpoints')->get();//all(); //withTrashed()->get();


        $affiliates = \App\Models\User::get()->filter(function($usr){
                return $usr->is('affiliate');
            });

        // lavacharts -----------------------
        //http://lavacharts.com/#datatables
        $graf = Lava::DataTable()
            ->addStringColumn('week')
            ;


        // posloži prodaje partnera po tjednima u polje
        $weeklypartnerpts=array();
        $partnerlist = array();
        foreach ($partners as $partner){
            // napuni listu za chainedselect
            $partnerlist[$partner->id]=$partner->name;
            // dodaj kolone u CHART
            $graf->addNumberColumn($partner->name);
            // napuni polje za vrijednosti CHARTa
            foreach ($partner->weeksales()->get()->sortBy('week') as $ws) {
                if(!array_key_exists($ws->week, $weeklypartnerpts)) $weeklypartnerpts[$ws->week]=array();                
                $weeklypartnerpts[$ws->week][$partner->id]=array('partner_name'=>$partner->name, 'total'=>$ws->total);
            }
        }
        ksort($weeklypartnerpts);

        // puni podatke u CHART
        foreach($weeklypartnerpts as $week=>$wps)
        {
            $rowData = [
              "W".$week
            ];
            foreach($partnerlist as $id=>$name){
                // ako nema vrijednosti, stavi 0 za tog partnera
                $pv=(array_key_exists($id,$wps)) ? $wps[$id]["total"]: 0;
                array_push($rowData,$pv);
            }

            $graf->addRow($rowData);
        }

        Lava::LineChart('PartnersWeekPoints', $graf, [
                'title' => 'Partner pts gained over weeks',
                'height' => 241,
                'legend' => [
                                'position' => 'bottom'
                            ]
                ]);
        // lavacharts end -------------------



        $sendData=[
            'partnerlist' => $partnerlist,
            'poses' => $poses,
            'affiliates' => $affiliates,
            'items' => $items,
        ];

        return view('adminHome')->with($sendData);

    }


    /**
     * Show the Admin application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function affiliateIndex()
    {

        $affiliate=Auth::user();
        $items=\App\Models\Item::with('latestpoints')->get()->filter(function($item){
                return $item->aktivan; // && $item->latestpoints && (int) $item->latestpoints->points > 0;
            });


        /* =========================================================================== */
        //      $weektopscores = \App\Models\User::orderBy('resultw','DESC')->get()->where('affiliate',true);

        //      NOVA VERZIJA... WEEK SCORES "on-the-fly" 
        //      ----------------------------------------

         $weektopscores = \App\Models\User::with('thisweeksales')->get()->where('affiliate',true);

         // složi collection?
         $wts=collect( );

         foreach ($weektopscores as $w) {

             $wts->push([
                'rbr'=>'-',
                'name'=>$w->name,
                'pos'=>($w->pos) ? $w->pos->name : "",
                'pts'=>($w->thisweeksales) ? $w->thisweeksales->sum('pivot.points') : 0,
                'qty'=>($w->thisweeksales) ? $w->thisweeksales->count('*') : 0,
                ]);

         }
         // sortiraj po bodovima
         $sortedwts = $wts->sortByDesc('pts');
         // dodaj redne brojeve
         $sortedwts->transform(function ($item, $key){
            Global $counter;
            $counter++;
            if ($item['pts']>0) {
                $item['rbr']=$counter;
            }
            return $item;
        });
        /* =========================================================================== */


        $sendData=[
            'affiliate'=>$affiliate,
            'items'=>$items,

            'weektopscores' =>$sortedwts
        ];


        return view('affiliateHome')->with($sendData);

    }




    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Auth::user()->can('accessAdminDashboard')) {
            return $this->adminIndex();
        } else if (Auth::user()->is('affiliate')) {
            return $this->affiliateIndex();
        } else {
            // nije ni admin ni affiliate...
            return view('home')->with($sendData);
        }

    }
}
