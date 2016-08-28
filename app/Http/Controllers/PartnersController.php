<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PartnersController extends Controller
{
    
    public function __construct()
    {
       $this->middleware('isAdmin');
    }

	/**
	 *  Show list of partners 
	 *
	 *  @return  \Illuminate\Http\Response
	 *  
	 */
	public function index(Request $request, $editOrCreatePartner=null, $editOrCreatePos=null, $createnew=false)
	{

		$poses = \App\Models\Pos::with('partner')->get();
		$partners = \App\Models\Partner::all();
		$partnerslist = \App\Models\Partner::lists('name','id');

		$sendData = array(
			'poses' => $poses,
			'partners' => $partners,
			'partnerslist' => $partnerslist,
			'createnew' => $createnew,
			'editOrCreatePartner' => $editOrCreatePartner,
			'editOrCreatePos' => $editOrCreatePos,
            'totalm' => $partners->sum('resultm'),
            'totalq' => $partners->sum('resultq'),
            'totalc' => $partners->sum('resultc')
			);

		return view('partners.index')->with($sendData);
	}	



	public function create(Request $request)
	{
		return $this->index($request, new \App\Models\Partner, new \App\Models\Pos,true);
	}

	public function edit(Request $request, $partner)
	{
		$partner=\App\Models\Partner::findOrFail($partner);
		return $this->index($request, $partner, new \App\Models\Pos,false);
	}
	public function editpos(Request $request, $pos)
	{
		$pos=\App\Models\Pos::findOrFail($pos);
		return $this->index($request, new \App\Models\Partner, $pos,false);
	}


	public function update(Request $request, $partner)
	{
		$partner=\App\Models\Partner::findOrFail($partner);

		// validacija
        $rules= [
            'partnername' => 'required|min:3|unique:partners,name,'.$partner->id,
        ];
        $messages = [
            'partnername.required' => 'Partner name cannot be empty! Pls name partner with at least 3 characters.',
            'partnername.min' => 'Partner name too short! Please name partner with at least 3 characters.',
            'partnername.unique' => 'Partner name already exists!',
        ];
        $this->validate($request,$rules,$messages);

		// store
        $partner->name=$request->input('partnername');
        $partner->save();

        return redirect('partners')->with('message','Partner data saved!');
	}

	public function updatepos(Request $request, $pos)
	{
		$pos=\App\Models\Pos::findOrFail($pos);

		// validacija
        $rules= [
            'newposname' => 'required|min:3|unique:poses,name,'.$pos->id,
        ];
        $messages = [
            'newposname.required' => 'POS name cannot be empty! Pls name POS with at least 3 characters.',
            'newposname.min' => 'POS name too short! Please name POS with at least 3 characters.',
            'newposname.unique' => 'POS name already exists!',
        ];
        $this->validate($request,$rules,$messages);

		// store
        $pos->name=$request->input('newposname');
        $pos->partner_id=$request->input('newpospartner') ? : null;
        $pos->save();

        return redirect('partners')->with('message','POS data saved!');
	}


	public function store(Request $request)
	{
		// validacija
        $rules= [
            'partnername' => 'required|min:3|unique:partners,name',
        ];
        $messages = [
            'partnername.required' => 'Partner name cannot be empty! Pls name partner with at least 3 characters.',
            'partnername.min' => 'Partner name too short! Please name partner with at least 3 characters.',
            'partnername.unique' => 'Partner name already exists!',
        ];
        $this->validate($request,$rules,$messages);

		// store
		$partner = new \App\Models\Partner;
        $partner->name=$request->input('partnername');
        $partner->save();

        return redirect('partners')->with('message','Partner created!');
	}
	public function storepos(Request $request)
	{
		// validacija
        $rules= [
            'newposname' => 'required|min:3|unique:poses,name',
        ];
        $messages = [
            'newposname.required' => 'POS name cannot be empty! Pls name POS with at least 3 characters.',
            'newposname.min' => 'POS name too short! Please name POS with at least 3 characters.',
            'newposname.unique' => 'POS name already exists!',
        ];
        $this->validate($request,$rules,$messages);

		// store
		$pos = new \App\Models\Pos;
        $pos->name=$request->input('newposname');
        $pos->partner_id=$request->input('newpospartner') ? : null;
        $pos->save();

        return redirect('partners')->with('message','POS created!');
	}


    public function destroypos(Request $request, $pos)
    {

        try{
            \App\Models\Pos::destroy($pos);
        } catch (\Exception $e) {
            return $this->index($request, null)->withErrors('Delete forbidden, there are users on this POS.');
        }

        return redirect('partners')->with('message', 'POS deleted!');
    }
    public function destroy(Request $request, $partner)
    {
        try{
            \App\Models\Partner::destroy($partner);
        } catch (\Exception $e) {
            return $this->index($request, null)->withErrors('Delete forbidden, partner has one or more POS.');
        }

        return redirect('partners')->with('message', 'Partner deleted!');
    }


}
