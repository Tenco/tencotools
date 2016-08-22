<?php

namespace tencotools;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    // define relationship
    public function projects() 
    {
        return $this->hasMany('tencotools\Project');
    }

    // define relationship
    public function relations() 
    {
        return $this->hasMany('tencotools\Relation', 'tenco_contact');
    }

    // define relationship
    public function Tasks() 
    {
        return $this->hasMany('tencotools\Task', 'responsible');
    }

     // define relationship
    public function ProjectFile() 
    {
        return $this->hasMany('tencotools\ProjectFile');
    }
}
