<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Support extends Model
{
    protected $table='support';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['name','value','type','active'];
}
