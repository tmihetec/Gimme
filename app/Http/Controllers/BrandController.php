<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class BrandController extends Controller
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
	public function index(Request $request, $editOrCreateBrand=null)
	{

		$brands = \App\Models\Brand::all();

		$sendData = array(
			'brands' => $brands,
			'editOrCreateBrand' => $editOrCreateBrand,
			);

		return view('brands.index')->with($sendData);
	}	


	public function store(Request $request)
	{
		$rules=[
			'brandname' => 'required|min:3|unique:brands,name'
		];
		$messages=[
			'brandname.required' => 'Brand name missing!',
			'brandname.min' => 'Brand name too short! Enter at least 3 characters.',
			'brandname.unique' => 'Brand name alrady exists!',
		];
		$this->validate($request,$rules,$messages);

		$brand=new \App\Models\Brand;
		$brand->name = $request->input("brandname");
		$brand->save();

        return redirect('brands')->with('message','Brand created!');
	}

	public function update(Request $request, $brand)
	{
		$rules=[
			'brandname' => 'required|min:3|unique:brands,name'
		];
		$messages=[
			'brandname.required' => 'Brand name missing!',
			'brandname.min' => 'Brand name too short! Enter at least 3 characters.',
			'brandname.unique' => 'Brand name alrady exists!',
		];
		$this->validate($request,$rules,$messages);

		$brand=\App\Models\Brand::findOrFail($brand);
		$brand->name = $request->input("brandname");
		$brand->save();

        return redirect('brands')->with('message','Brand data saved!');
	}

	public function edit(Request $request, $brand)
	{
		$brand=\App\Models\Brand::findOrFail($brand);
		return $this->index($request, $brand);		
	}

	public function create(Request $request)
	{
		return $this->index($request, new \App\Models\Brand);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {

        try{
            \App\Models\Brand::destroy($id);
        } catch (\Exception $e) {
            return $this->index($request, null)->withErrors('Delete forbidden, there are Items with this brand.');
        }

        $request->session()->flash('message', 'Brand deleted!');
        return $this->index($request, null)->with('message','ok');

    }
}

