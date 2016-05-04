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


		$user = \tencotools\User::findOrFail($user_id);
		return $user['name'];
		

	}


	function set_active($path)
	{
		return request()->is($path) ? 'active' : '';

	}