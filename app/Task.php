<?php

namespace tencotools;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

	// protect against massassignment
	protected $fillable = [
							'name',
							'desc',
							'img',
							/*	'created_by', ska ej kunna manipuleras via request-data. 
								hanteras via Auth i controller */
							'responsible',
							'prio',
							'stage',
							'deadline'
						];

    // define relationship
	public function project() 
	{
		return $this->belongsTo('tencotools\Project');
	}
}
