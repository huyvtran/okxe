<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\ListModel;

class Feedback extends ListModel
{
    protected $table='feedback';

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['id_user','title','content','created_at','updated_at','active','status','rating','contactable'];

    public $statuses = ['New','Noted','Processed','Ignore'];

    public $rates = ['Rất tuyệt','Tạm được','Chưa tốt lắm'];

     /**
     * Relationship: user
     *
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
     *         created_at =>datetime,
     *         date_upd =>datetime,
     *         active =>tinyint
     * )
     */
    public function user(){
    	return $this->belongsTo('App\User','id_user');
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
    *        'feedbacks' => array(
    *            'feedback.id' => int
    *            'feedback.title' => str
    *            'feedback.id_user' => str
    *            'feedback.content' => str
    *            'feedback.rating' => str,
    *            'feedback.contactable' => tinyint,
    *            'feedback.status' =>str
    *            'feedback.created_at' => date/time
    *            'user.phone' => str
    *            'user.name' => str
    *        ),
    *        totalData => int,
    *        totalFiltered => int
    *        ))
    */
    public function filter(Request $request,$rows,$columns,$table){
        $query = parent::filter($request,$rows,$columns,$table);
        $total_filtered = $query->count();
        $order_column = $columns[$request['order'][0]['column']];
        if ($order_column == 'phone' || $order_column == 'name') {
            if (strpos($query->toSql(), 'left join') == false) {
                $query->leftJoin('user',function($join){ $join->on('user.id','=','feedback.id_user'); });  
            }
            $query->orderBy('user.'.$order_column,$request['order'][0]['dir']);
        } else {
            $query->orderBy($order_column,$request['order'][0]['dir']);
        }
        $query->skip($request['start'])->take($request['length']);
        return [
            'feedbacks' => $query->get(),
            'totalData' => $this->count(),
            'totalFiltered' => $total_filtered
        ];
    }
}
