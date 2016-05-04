<?php

namespace tencotools\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use tencotools\Http\Requests;
use tencotools\Relation;
use tencotools\User;

use Auth;
use Session;
use Carbon\Carbon;


class RelationsController extends Controller
{

	public function __construct() 
	{
  		$this->middleware('auth');
	}
    


	/*
	*
	* get all relations
	* return view
	*/
	public function home()
	{

		#$relations = Relation::all();

		return view('relations.home');
	}

	/*
	*
	* display new relation form
	* return view
	*/
	public function create()
	{

		$users = User::all();
		
		return view('relations.createRelation', compact('users'));
	}


	/*
	*
	* Save a new relation
	*
	*/
	public function store(Request $request, Relation $relation)
	{
		$this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:relations',
            'tenco_contact' => 'required'
            ]);


    	$r = $relation->create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'phone' => $request->phone,
    		'company' => $request->company,
    		'tenco_contact' => $request->tenco_contact
    	]);

    	return redirect('/relation/image/'. $r->id);

	}


	/*
	*
	* get all projects
	* return view
	*/
	public function uploadImage($relation)
	{

		$relation = Relation::where('id', $relation)->first();
		

		return view('relations.createRelation2', compact('relation'));

	}

	/*
	*
	* Store project image locally
	*
	*/
	public function storeImage(Request $request, Relation $relation)
	{
		// VALIDATION 
		if( ! $request->hasFile('file'))
			return response()->json(['error' => 'No File Sent']);

		$this->validate($request, [
				'file' => 'required|mimes:jpeg,jpg,png',
			]);

		$uploadedfile = $request->file('file');
		$new_file_name = time() . $uploadedfile->getClientOriginalName();
		$uploadedfile->move('img/relations/', $new_file_name);

		$relation->update([
			'img' => $new_file_name,
			]);

		return response()->json(['success' => 'ok']);
	}

}
