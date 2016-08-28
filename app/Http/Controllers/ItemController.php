<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('isAdmin', [
            'except'=>  [
                            'activeItems'
                        ]
        ]);
    }

    /**
     * list of active incentive items for affiliates, only notTrashed, only with points>0, without commands
     * @return [type] [description]
     */
    public function activeItems(){

        $items=\App\Models\Item::with('category','brand')
            ->with(['latestpoints'=>function($q){
                $q->where('points','>',0);
            }])
            ->where('active','=',1)
            ->get()
            ;

        $sendData=[
            'items'=>$items,
        ];


        return view('items.overwiev')->with($sendData);

    }



    /**
     * list incentive items
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $items=\App\Models\Item::with('category','brand','latestpoints')->get();//all(); //withTrashed()->get();

        $sendData=[
            'items'=>$items,
        ];


        return view('items.index')->with($sendData);

    }


    public function edit(Request $request, $item)
    {
        
        return $this->create($request, $item, false);//view('items.edit')->with($sendData);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request, $item=null, $createnew=true)
    {

        $editOrCreateItem = ($item) ? \App\Models\Item::findOrFail($item) : new \App\Models\Item;
        $categories = \App\Models\Category::all(); // kasnije, samo aktivne! *v2tmk*
        $brands = \App\Models\Brand::all(); // kasnije, samo aktivne! *v2tmk*
        $items=\App\Models\Item::with('category','brand')->get();//all(); //withTrashed()->get();

        $sendData = [
            'editOrCreateItem' => $editOrCreateItem,
            'categories' => $categories,
            'createnew' => $createnew,
            'brands' => $brands,
            'items' => $items,
        ];
        return view('items.create')->with($sendData);
       // return View::make('komitenti.create')->with(['komitent'=>$komitent]);
    }


    public function toggleActive(Request $request, $item)
    {
        $item = \App\Models\Item::findOrFail($item);
        $item->active = ($item->active == 1) ? 0 : 1;
        $item->save();
        return redirect("items");
    }

    public function destroy(Request $request, $id)
    {

        try{
            \App\Models\Item::destroy($id);
        } catch (\Exception $e) {
            return $this->index($request, null)->withErrors('Delete forbidden, there are Realisations with this item.');
        }

        // ak je prošlo, onda daj zbriši i PTS history, jbga
        // al ne softdelete, to nam netreba 
        \App\Models\Itempoints::where('item_id','=',$id)->delete();

        return redirect("items")->with('message','Item deleted!');

    }

    public function store(Request $request, $item=null)
    {

        // SKU TREBA BITI UNIQUE!! (pazi kod EDIT da se doda i ID!)
        
        $rules=[
            'name' => 'required|min:3',
            'nc'   => 'numeric',
            'points' => 'integer',
        ];
        $messages=[
            'name.required' => 'Please enter item name. Enter at least 3 characters.',
            'name.min' => 'Item name too short. Please enter at least 3 characters.',
            'points.integer' => 'Item points must be integer.',
            'nc.numeric' => 'Item purchase price must be numeric.',
        ];
        $this->validate($request, $rules, $messages);

        if ($item) 
        { 
            $item = \App\Models\Item::findOrFail($item); 
            $mes="Item data saved!";
            $zadnjibodovi = ($item->latestpoints) ? $item->latestpoints->points : false;
        } else {
            $item = new \App\Models\Item; 
            $mes="Item created!";
            $zadnjibodovi=false;
        } 
    
        $item->name = $request->input('name');
        $item->pn = $request->input('pn');
        $item->sku = $request->input('sku');
        $item->nc = $request->input('nc');
        $item->category_id = $request->input('category');
        $item->brand_id = $request->input('brand');
        $item->active = $request->input('active');

        //save
        $item->save();

        // treba vidjeti da li ima promjene cijene? ili možda kasnije naziva prodajne akcije/startdatuma
        if ($zadnjibodovi !== (int) $request->input('points'))
        {
            //save POINTS to history
            $points = new \App\Models\Itempoints();
            $points->item_id = $item->id;
            $points->startdate = date("Y-m-d");
            $points->points = $request->input('points');
            $points->user_id = \Auth::user()->id;
            $points->save();            
        }


        return redirect("items")->with('message',$mes);
    }

    public function update(Request $request, $item)
    {
        return $this->store($request, $item);
    }


}
