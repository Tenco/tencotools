<?php

namespace tencotools;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relation extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

	// protect against massassignment
	protected $fillable = [
							'name',
							'email',
							'phone',
							'company',
							'img',
							'tenco_contact',
							'event_id'
						];



	 // define relationship
	public function user()
	{
		return $this->belongsTo('tencotools\User');
	}

 	// define many2many relationship
    /*
    public function Projects() 
    {
        return $this->belongsToMany('tencotools\Project', '[pivot table name]');
    }
    */

}
