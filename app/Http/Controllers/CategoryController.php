<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CategoryController extends Controller
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
	public function index(Request $request, $editOrCreateCategory=null)
	{

		$categories = \App\Models\Category::all();

		$sendData = array(
			'categories' => $categories,
			'editOrCreateCategory' => $editOrCreateCategory,
			);

		return view('categories.index')->with($sendData);
	}	


	public function store(Request $request)
	{
		$rules=[
			'categoryname' => 'required|min:3|unique:categories,name'
		];
		$messages=[
			'categoryname.required' => 'Category name missing!',
			'categoryname.min' => 'Category name too short! Enter at least 3 characters.',
			'categoryname.unique' => 'Category name alrady exists!',
		];
		$this->validate($request,$rules,$messages);

		$category=new \App\Models\Category;
		$category->name = $request->input("categoryname");
		$category->save();

        return redirect('categories')->with('message','Category created!');
	}

	public function update(Request $request, $category)
	{
		$rules=[
			'categoryname' => 'required|min:3|unique:categories,name'
		];
		$messages=[
			'categoryname.required' => 'Category name missing!',
			'categoryname.min' => 'Category name too short! Enter at least 3 characters.',
			'categoryname.unique' => 'Category name alrady exists!',
		];
		$this->validate($request,$rules,$messages);

		$category=\App\Models\Category::findOrFail($category);
		$category->name = $request->input("categoryname");
		$category->save();

        return redirect('categories')->with('message','Category data saved!');
	}

	public function edit(Request $request, $category)
	{
		$category=\App\Models\Category::findOrFail($category);
		return $this->index($request, $category);		
	}

	public function create(Request $request)
	{
		return $this->index($request, new \App\Models\Category);
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
            \App\Models\Category::destroy($id);
        } catch (\Exception $e) {
            return $this->index($request, null)->withErrors('Delete forbidden, there are Items in this category.');
        }

        $request->session()->flash('message', 'Category deleted!');
        return $this->index($request, null)->with('message','ok');

    }
}

