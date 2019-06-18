<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
       protected $table='employee';
       
   	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   	protected $fillable=['name','email','username','password','type','active'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     *
     * @return 
     *      <pre>       
     *        array(
     *        name => string,
     *        active => int,
     *        id_employee => int,
     *        created_at => date/time,
     *        updated_at => date/time,
     * )
     */
    public function brands(){
        return $this->hasMany('App\Brand','id_employee');
    }
}
