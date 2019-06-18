<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\ListModel;

class Brand extends ListModel
{
    protected $table='brand';
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['name','active','id_employee'];

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
        return $this->hasMany('App\Item','id_brand');
    }
     
   	 /**
     * Relationship: models
     *
     * @return array(
     *        name => varchar,
     *        active => tinyint,
     * )
     */
   	public function models(){
   		return $this->hasMany('App\Models','id_brand');
    }

    /**
     *
     *
     * @return 
     *        <pre>
     *        array(
     *        name => string,
     *        email => string,
     *        username => string,
     *        type => string,
     *        created_at => datetime,
     *        updated_at => datetime,
     * )
     */
    public function employee(){
      return $this->belongsTo('App\Employee','id_employee');
    }

    /**
    *   Filter data by specified condition
    *   @param Request $request
    *   @param array $rows
    *   @param array $columns
    *   @param string $table
    *   @return
    *        <pre>
    *        array(
    *        'brands' => array(
    *            'brand.id' => int
    *            'brand.name' => str
    *            'brand.id_employee' => str
    *            'brand.status' =>str
    *            'brand.created_at' => date/time
    *        ),
    *        totalData => int,
    *        totalFiltered => int
    *        ))
    */
    public function filter(Request $request,$rows,$columns,$table){
      $query = parent::filter($request,$rows,$columns,$table);
      $total_filtered = $query->count();
      $order_column = $columns[$request['order'][0]['column']];
      if ($order_column == 'employee') {
          $query->leftJoin('employee',function($join){ $join->on('employee.id','=','brand.id_employee'); });  
          $query->orderBy('employee.'.$order_column,$request['order'][0]['dir']);
      } else {
          $query->orderBy($order_column,$request['order'][0]['dir']);
      }
      $query->skip($request['start'])->take($request['length']);
      return [
          'brands' => $query->get(),
          'totalData' => $this->count(),
          'totalFiltered' => $total_filtered
      ];
  }
     
}
