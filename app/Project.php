<?php

namespace tencotools;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    
    protected $dates = ['deadline'];

	// protect against massassignment
	protected $fillable = [
							'name',
							'desc',
							'img',
							'project_owner',
							'created_by',
							'value',
							'cost',
							'close_date',
							'deadline',
							'slack',
							'invision',
							'blog'
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

	// define relationship
    public function ProjectFile() 
    {
        return $this->hasMany('tencotools\ProjectFile');
    }

    // define relationship
    public function ProjectTime() 
    {
        return $this->hasMany('tencotools\ProjectTime');
    }

}
