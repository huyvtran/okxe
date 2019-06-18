<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Items;
class Models extends Items
{
    protected $table='model';
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['name','id_brand','active'];
        /**
     * Relationship: brand
     *
     * @return array(
     *         name => varchar,
     *         active => tinyint,
     * )
     */
    public function brand(){
    	return $this->belongsTo('App\Brand','id_brand');
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
        return $this->hasMany('App\Item','id_model');
    }
    
}
