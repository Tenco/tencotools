<?php namespace Helpers;


	function TaskIdToName($task_id)
	{
		$task = \tencotools\Task::findOrFail($task_id);
		return $task['name'];

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