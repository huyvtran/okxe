<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    protected $table='cms';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['title','content','date_add','date_upd','active'];

}
