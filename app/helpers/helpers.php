<?php namespace Helpers;


	function TaskIdToName($task_id)
	{
		$task = \tencotools\Task::findOrFail($task_id);
		return $task['name'];

	}


	function ProjectIdToName($project_id)
	{
		$project = \tencotools\Project::findOrFail($project_id);
		return $project['name'];

	}
	
	/**
	*
	* translare user_id to name
	* Return "string"
	*
	*/
	function UserIdToName($user_id)
	{

		#dd($user_id);

		#$user = \tencotools\User::findOrFail($user_id);
		$user = \tencotools\User::withTrashed()
                ->where('id', $user_id)
                ->first();

		return $user['name'];
		

	}


	/**
	*
	* determen what top-menu to show as active
	* Return "string"
	*
	*/
	function set_active($path)
	{

		
		$url = request()->path();

		if (strstr($url, $path))
		{	
			echo 'active';
		}
				

	}