<?php

namespace tencotools;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectTime extends Model
{

	use SoftDeletes;

	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [	
    						'deleted_at',
    						'billed',
    						'payed',
    						'startdate',
    						'enddate',
    					];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
					        'created_by', 
					        'project_id',
					        'billed',
					        'payed',
					        'startdate',
					        'enddate',
 						   ];


	// define relationship
	public function Project() 
	{
		return $this->belongsTo('tencotools\Project', 'project_id');
	}
}
