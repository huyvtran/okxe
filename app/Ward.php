<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Ward extends Items
{
    protected $table='ward';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['id_county','name','active'];
     /**
     * Relationship: county
     *
     * @return array(
     *         name => string,
     *         active => tinyint,
     * )
     * 
     * */
    public function county(){
    	return $this->belongsTo('App\County','id_county');
    }
     /**
     * Relationship: items
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function items(){
    	return $this->hasMany('App\Item','id_ward');
    }
}
