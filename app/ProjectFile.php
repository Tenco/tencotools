<?php

namespace tencotools;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectFile extends Model
{

	use SoftDeletes;

	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
