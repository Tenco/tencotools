<?php

namespace tencotools\Http\Controllers;

use Illuminate\Http\Request;

use tencotools\Http\Requests;

use tencotools\User;
use tencotools\Project;
use tencotools\ProjectFile;
use Auth;
use Storage;
use Session;
use Carbon\Carbon;

class ProjectFilesController extends Controller
{
    
	
	public function __construct() 
	{
  		$this->middleware('auth');
	}
    

    /*
	*
	* Store project project files on Cloud server
	*
	*/
	public function storeFile(Request $request, Project $project)
	{
		// VALIDATION 
		if( ! $request->hasFile('file'))
			return response()->json(['error' => 'No File Sent']);


		$uploadedfile = $request->file('file');

		foreach ($uploadedfile as $duh)
		{
			
			#$new_file_name = time() . $duh->getClientOriginalName();
			$path = '/project#'.$project->id.'/'.time().'/';

			// save file to Dropbox-folder
			$r = Storage::disk('dropbox')->put($path . $duh->getClientOriginalName(), file_get_contents($duh));
			if ($r)
			{
				// insert file info into DB
				$this->newProjectFilesEntry($duh->getClientOriginalName(), $path, $project->id);
			}
		}

		return response()->json(['success' => 'ok']);
	}


	/*
	*
	* Store project project files on Cloud server
	*
	*/
	public function download($file)
	{
		
		$file = base64_decode($file);
		#dd($file);

		if ( ! Storage::disk('dropbox')->exists($file))
		{
			dd('file: '.$file.' does not seem to exist?');
		}

		$mime = Storage::disk('dropbox')->mimeType($file);
		$contents = Storage::disk('dropbox')->get($file);
		
        $headers = array(
              'Content-Type: '.$mime,
            );

        #ob_end_clean();
        
        return response($contents)
        	  ->header('Content-Type', $mime);
        
	}


	private function newProjectFilesEntry($name, $path, $project_id)
	{
		
		$ProjectFile = new ProjectFile;

        $ProjectFile->name = $name;
        $ProjectFile->path = $path;
        $ProjectFile->project_id = $project_id;
        $ProjectFile->user_id = Auth::id();
        $ProjectFile->save();
		return;
	}
}
