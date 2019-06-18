<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table='notification';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['message','date_add','data_upd','active'];
      /**
     * Relationship: user
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
     * )
     */
    public function users(){
        return $this->belongsToMany('App\User','user_notification','id_user','id_notification');
    }
}
