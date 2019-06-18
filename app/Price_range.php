<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Price_range extends Model
{
    protected $table='price_range';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['price','id_brand','id_model'];
}
