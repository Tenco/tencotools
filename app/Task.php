<?php

namespace tencotools;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class Task extends Model
{

	
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'deadline'];

	// protect against massassignment
	protected $fillable = [
							'name',
							'desc',
							'img',
							'created_by',
							'responsible',
							'prio',
							'stage',
							'deadline',
							'project_id',
							'blockedby'
						];

    // define relationship
	public function project() 
	{
		return $this->belongsTo('tencotools\Project');
	}


	// define relationship
	public function user() 
	{
		return $this->belongsTo('tencotools\User', 'responsible');
	}
}
