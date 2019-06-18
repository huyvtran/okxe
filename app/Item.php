<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ListModel; 
use Illuminate\Http\Request;
use DB;

class Item extends ListModel
{
    protected $table='item';
   
/*
    *
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['id','title','description','color','id_province','id_county','id_ward','id_user','id_brand','id_model','type','engine_power','price','seri','number','year','created_at','updated_at','status'];

    public $statuses = ['New','Active','Cancelled','Inactive','Hot','Under review','Rejected'];
    
     /**
     * Relationship: province
     * @param 
     * @return array(
     *       name => varchar,
     *       active => tinynt,
     * ) 	
     */
    public function province(){
    	return $this->belongsTo('App\Province','id_province');
    }
    /**
     * Relationship: country
     * @param 
     * @return array(
     *         name => varchar, 
     *         id_provine => int,
     *         active => tinynt,
     * )
     */
    public function county(){
    	return $this->belongsTo('App\County','id_county');
    }
    /**
     * Relationship: ward
     * @param 
     * @return array(
     *         name => varchar,
     *         id_county => int,
     *         active => tinynt,
     * )
     */
    public function ward(){
    	return $this->belongsTo('App\Ward','id_ward');
    }
    /**
     * Relationship: brand
     * @param 
     * @return array(
     *         name => varchar,
     *         active => tinynt,
     * )
     */
    public function brand(){
    	return $this->belongsTo('App\Brand','id_brand');
    }
    /**
     * Relationship: model
     * @param 
     * @return array(
     *         name => varchar,
     *         id_brand => int,
     *         active => tinynt,
     * )
     */
    public function model(){
    	return $this->belongsTo('App\Models','id_model');
    }
    /**
     * Relationship: user
     * @param 
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
    public function user(){
    	return $this->belongsTo('App\User','id_user');
    }
    /**
     * Relationship: images
     * @param 
     * @return array(
     *        name => varchar
     *        cover => tinyint, 
     * )
     */
    public function images(){
    	return $this->hasMany('App\Image','id_item');
    }
    /**
     * @param $field,$order,$paginate,$select[];
     * @return array( int=> array(
     *        id => int,
     *        name => varchar,
     *        id_province => int,
     *        seri => varchar,
     *        price => double,
     *        status => enum,
     *        date_add =>date_time,
     * )
     * )->orderby->paginate;
     */
    public function getList($field = 'id',$order = 'desc',$paginate = 5,$select=['id','name','id_province','seri','price','status','date_add']){
        return  $this->select($select)->orderBy($field,$order)->paginate($paginate);
    }
    /**
     * @param int $id;
     * @return Item;
     */
    public function getDetail($id){
        $item =  $this->with('images')->with('province')->with('user')->with('ward')->where('id','=',$id)->first();
        if(!$item) throw new \Exception(trans('label.cant_found_the_item'));

        return $item;
    }
    /**
    *   Filter data by specified condition
    *   @param Request $request
    *   @param array $rows
    *   @param array $columns
    *   @param string $table
    *   @return array(
    *        <pre>
    *        array(
    *        'users' => array(
    *            'item.id' => int,
    *            'item.title' => str,
    *            'item.status' => str,
    *            'user.price' => float,
    *            'user.seri' => str,
    *            'user.last_visit' =>datetime,
    *            'user.id_province' => int
    *        ),
    *        totalData => int,
    *        totalFiltered => int
    *        )
    */
    public function filter(Request $request,$rows,$columns,$table){
        $query = parent::filter($request,$rows,$columns,$table);
        $total_filtered = $query->count();
        $query->orderBy($columns[$request['order'][0]['column']],$request['order'][0]['dir'])
                ->skip($request['start'])->take($request['length']);
        return [
            'items' => $query->get(),
            'totalData' => $this->count(),
            'totalFiltered' =>  $total_filtered
        ];
    }
    
    /**
     *   Count total and active items
     *   @param Request $request
     *   @return array(
     *       <pre>
     *       'total' => int,
     *       'active' => int,
     *       'date' => datetime
     *   )
    */
    public function countItemData(Request $request){
        $sql = $this->selectRaw("LEFT(`created_at`, 10) AS date,count(id) as total,CAST(SUM(status = 'Active') as UNSIGNED) as active")
                        ->whereRaw('LEFT(`created_at`, 10) >="'.$request->day_from.'"')
                        ->whereRaw('LEFT(`created_at`, 10) <='.'"'.$request->day_to.' 23:59:59"'); 
        switch ($request->type) {
            case 'Day':
                $sql->groupBy(DB::raw('LEFT(`created_at`, 10)'));
                break;
            case 'Week':
                $sql->groupBy(DB::raw('WEEK(`created_at`, 1)'));
                break;
            default:
                $sql->groupBy(DB::raw('MONTH(`created_at`)'));
                break;
        }
        return $sql->orderBy(DB::raw('LEFT(`created_at`,10)'))->get();
    }

    /**
     *   Get the statistics of items
     *   @param Request $request
     *   @param $table
     *   @param $limit
     *   @return array(
     *       <pre>
     *       'name' => string,
     *       'id' => int,
     *       'total' => int,
     *       'active' => int
     *   )
    */
    public function getItemStatistics(Request $request,$table,$limit){
        $sql = $this->select($table['table'].".name as name",$table['table'].".id as id") 
                ->selectRaw("count(item.id) as total,CAST(SUM(item.status = 'Active') as UNSIGNED) as active")
                ->leftJoin($table['table'],$table['table'].'.id','=','item.'.$table['on']);
        if($table['table'] == 'model'){
            $sql->selectRaw("brand.name as bname")
                ->leftJoin('brand','brand.id','=',$table['table'].'.id_brand');
        }
        return $sql->whereRaw('LEFT(item.`created_at`, 10)>="'.$request->day_start.'"')
            ->whereRaw('LEFT(item.`created_at`, 10) <='.'"'.$request->day_to.' 23:59:59"')
            ->whereNotNull($table['table'].'.id')
            ->groupBy('item.'.$table['on'])
            ->orderBy('active','desc')
            ->take($limit)
            ->get();
    }

}
