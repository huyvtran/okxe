<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Items
{

    protected $table='province';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['name','active'];
     /**
     * Relationship: item
     *
     * @return array(
     *       name => varchar,
     *       description => text,
     *       color => varchar,
     *       id_county => int,
     *       id_province => int,
     *       id_user => int,
     *       id_brand => int,
     *       id_model => int,
     *       type => enum,
     *       engine_power => enum
     *       price => double,
     *       seri => varchar,
     *       date_add => date_time,
     *       date_upd => date_time,
     *       status => enum,  
     * )
     */
    public function items(){
    	return $this->hasMany('App\Item','id_province');
    }
     /**
     * Relationship: county
     *
     * @return array(
     *         name => varchar,
     *         id_province => int,
     *         active => tinyint,
     * )
     */
    public function counties(){
    	return $this->hasMany('App\County','id_province');
    }
}
