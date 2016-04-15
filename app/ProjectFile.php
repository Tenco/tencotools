<?php

namespace tencotools;

use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'path', 'project_id',
    ];

     // define relationship
	public function user() 
	{
		return $this->belongsTo('tencotools\User');
	}


	// define relationship
	public function Project() 
	{
		return $this->belongsTo('tencotools\Project', 'responsible');
	}
}
