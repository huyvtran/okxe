<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Profile extends Model
{
    protected $table='profile';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['name','active'];
     /**
     * Relationship: users
     *
     * @return array(
     *         name=>varchar,
     *         email =>varchar,
     *         username => varchar,
     *         password => varchar,
     *         id_profile = > int,
     *         id_province => int,
     *         id_Ward => int,
     *         id_county =>int,
     *         phone => varchar,
     *         avatar => varchar,
     *         date_add =>datetime,
     *         date_upd =>datetime,
     *         active =>tinyint
     *)
     */
    public function users(){
    	return $this->hasMany('App\User','id_profile');
    }
}
