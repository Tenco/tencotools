<?php

namespace tencotools;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    
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
    public function Tasks() 
    {
        return $this->hasMany('tencotools\Task');
    }
}
