<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table='image';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['id_item','name','cover'];

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
    public function item(){
    	return $this->belongsTo('App\Item','id_item');
    }
}
