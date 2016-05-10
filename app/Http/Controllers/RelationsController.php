<?php

namespace tencotools\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use tencotools\Http\Requests;
use tencotools\Relation;
use tencotools\User;

use DB;
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

		$relations = DB::table('relations')
				->whereNull('deleted_at') // soft deletes not working?! :(
                ->orderBy('name', 'asc')
                ->paginate(17);

		return view('relations.home', compact('relations'));
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
    		'img' => 'relations.png',
    		'tenco_contact' => $request->tenco_contact
    	]);

    	return redirect('/relations/image/'. $r->id);

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

		#dd($relation);
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


	/*
	*
	* display a single contact
	* 
	*/
	public function show(Relation $relation)
	{
		// nedan behövs ej pga Route/modal-binding ..alltså hela relation objektet laddas 
		// genom att type hinta ovan baserat på det wildcard som skickas in till funktionen.
		#$relation = Relation::find($relation);
		
		
		return view('relations.contactCard', compact('relation'));
		

	}

	/*
	*
	* 
	*
	*/
	public function edit(Request $request, Relation $relation)
	{
		// eagerload the project owner data
		$relation->load('user'); // load user-data for this project
		$allusers = User::all(); // load all data in user table


		return view('relations.editRelation', compact('relation', 'allusers'));

	}

	/*
	*
	* 
	*
	*/
	public function update(Request $request, $relation)
	{


		// validation:
		$this->validate($request, [
            'name' => 'required',
            //'email' => 'required|email|unique:relations,'.$request->segment(2),
            'tenco_contact' => 'required'
            ]);


    	Relation::where('id', $relation)
          ->update([
    		'name' => $request->name,
    		'email' => $request->email,
    		'phone' => $request->phone,
    		'company' => $request->company,
    		'tenco_contact' => $request->tenco_contact
    	]);

		Session::flash('flash_message', 'Contact updated');

		$url = '/relations/'.$request->segment(2).'/edit';

		return redirect($url);

	}


	/*
	*
	* 
	*
	*/
	public function search(Request $request)
	{

		$this->validate($request, [
            'q' => 'required'
            ]);
		
		#dd($request->q);
		$relations = DB::table('relations');
    	$results = $relations->where('name', 'LIKE', '%'. $request->q .'%')
		    ->orWhere('email', 'LIKE', '%'. $request->q .'%')
		    ->orWhere('phone', 'LIKE', '%'. $request->q .'%')
		    ->orWhere('company', 'LIKE', '%'. $request->q .'%')
		    ->distinct()
		    //->take(17)
		    ->get();

		 
		#dd($results);
		$query = $request->q;
    	return view('relations.searchResult', compact('results', 'query'));

	}


 	/*
    *
    *  delete a contact
    *
    */
	public function remove($relation)
	{
		// delete the task in DB
        Relation::destroy($relation);

        Session::flash('flash_message', 'Contact deleted. <a href="/relations/'.$relation.'/undo">Undo.</a>');
        return redirect('/relations');

	}


	 /*
    *
    *  revive a deleted contact
    *
    */
    public function restore($relation)
    {

        Relation::withTrashed()
            ->where('id', $relation)
            ->restore();

        
        Session::flash('flash_message', 'Contact revived.');
        
        return back();
    }

}
