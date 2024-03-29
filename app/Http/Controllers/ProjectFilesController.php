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
			
			if (\App::environment('local')) 
			{
				// The environment is local
				$path = '/development/project#'.$project->id.'/'.time().'/';
			}
			else
			{
				// PROPDUCTION
				$path = '/project#'.$project->id.'/'.time().'/';	
			}
			
			

			$file_name = pathinfo($duh->getClientOriginalName(), PATHINFO_FILENAME); // file
			$extension = pathinfo($duh->getClientOriginalName(), PATHINFO_EXTENSION); // jpg
			$filename = str_slug($file_name).'.'.$extension;

			// save file to Dropbox-folder
			$r = Storage::disk('dropbox')->put($path . $filename, file_get_contents($duh));
			if ($r)
			{
				// insert file info into DB
				$this->newProjectFilesEntry($filename, $path, $project->id);
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

	
	/*
    * softdelete file but only from DB
    * 
    *
    */
    public function remove($file)
    {

        ProjectFile::destroy($file);


        Session::flash('flash_message', 'File deleted.');
        return back();

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

	public function getFileUserName()
	{
		return $this->user->name;
	}
}
