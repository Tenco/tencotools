<?php

namespace tencotools;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    
	// protect against massassignment
	protected $fillable = [
							'name',
							'desc',
							'img',
							'value',
							'cost',
							'close_date',
							'deadline'
						];

	// define relationship
	public function tasks() 
	{
		return $this->hasMany('tencotools\Task');
	}

	// define relationship
	public function user()
	{
		return $this->belongsTo('tencotools\User', 'project_owner');
	}

}
