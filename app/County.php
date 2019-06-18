<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class County extends Items
{
    protected $table='county';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['name','id_province','active'];
     /**
     * Relationship: province
     *
     * @return array(
     *         name => varchar,
     *         active => tinyint,
     * )
     */
    public function province(){
    	return $this->belongsTo('App\Province','id_province');
    }
    /**
     * Relationship: items
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
    	return $this->hasMany('App\Item','id_county');
    }
    /**
     * Relationship: wards
     *
     * @return array(
     *         name => string,
     *         active => tinyint,
     *         id_county => int,
     * )
     */
    public function wards(){
    	return $this->hasMany('App\Ward','id_county');
    }

}
