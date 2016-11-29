<?php

namespace tencotools\Http\Controllers;

use Illuminate\Http\Request;

use tencotools\Http\Requests;

use Auth;
use tencotools\User;
use tencotools\ProjectTime;

use tencotools\Project;

class ProjectTimeController extends Controller
{
    

	/*
	*
	* Save a new pjoject time entry
	*
	*/
	public function store(Request $request, $project_id)
	{
		
		$this->validate($request, [
            'hours' => 'required|numeric',
            'startDate' => 'required|date|date_format:Y-m-d',
            'endDate' => 'required|date|date_format:Y-m-d|after:startDate'
            ]);


		$ProjectTime = new ProjectTime;

        $ProjectTime->created_by = Auth::id();
        $ProjectTime->project_id = $project_id;
        $ProjectTime->startdate = $request->startDate;
        $ProjectTime->enddate = $request->endDate;
        $ProjectTime->hours = $request->hours;

        $ProjectTime->save();

    	return response()->json(['success' => 'ok']);
    	

	}

}
