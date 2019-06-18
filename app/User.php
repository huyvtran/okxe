<?php
namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use DB;

class User extends Authenticatable
{   
    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','username', 'password','phone','avatar','id_profile','id_province','id_ward','id_county','created_at','updated_at','status'
    ];

    public $statuses = ['Active','Pending','Banned','Inactive'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $folder= 'public/images/';
    /**
    * Get the avatar of the user     
    */
    public function getAvatarAttribute($value){
        return $this->folder . $value;
    }

    /**
     * Relationship: items
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function items(){
        return $this->hasMany('App\Item','id_user');
    }

    /**
     * Relationship: profile
     *
     * @return array(
     *         name => varchar,
     *         active => tinyint,
     * )
     */
    public function profile(){
        return $this->belongsTo('App\Profile','id_profile');
    }

      /**
     * Relationship: notification
     *
     * @return array(
     *         message => text,
     *         date_add => datetime,
     *         date_upd => datetime,
     *         active => tinyint
     * )
     * 
     */
    public function notifications(){
        return $this->belongsToMany('App\Notification','user_notification','id_user','id_notification');
    }

     /**
     * Relationship: feedbacks
     *
     * @return array(
     *         title   => varchar,
     *         content => text,
     *         date_add => datetime,
     *         date_upd => datetime,
     *         active => tinyint
     * )
     * 
     */
    public function feedbacks(){
        return $this->hasMany('App\Feedback','id_user');
    }

    /**
    *   
    *   @param string $status
    *   @return number 
    */
    public function getTotalByStatus($status){
        return count($this->items->where('status',$status));
    }

    /**
    *   Filter data by specified condition
    *   @param Request $request
    *   @return array(
    *        <pre>
    *        array(
    *        'users' => array(
    *            'user.id' => int,
    *            'user.name' => str,
    *            'user.status' => str,
    *            'user.phone' => str,
    *            'user.last_visit' =>datetime,
    *            'user.created_at' => datetime
    *        ),
    *        totalAmount => int,
    *        totalFiltered => int
    *        )
    */
    public function filter($request){
        $columns = array('id', 'phone','name','items','under review','active','inactive','rejected','cancelled','status','created_at','last_visit');

        $query =     $this->select('user.id','user.name','user.status','user.phone','user.last_visit','user.created_at');
        foreach($request['columns'] as $rkey=>$rvalue){
            $value = $request['columns'][$rkey]['search']['value'];
            $column  = $request['columns'][$rkey]['data'];
            if (!empty($value)) {
                if($column == 'created_at' || $column == 'last_visit'){
                    $range_date = explode('-',$request['columns'][$rkey]['search']['value']);
                    $day_from = $range_date[0];
                    $day_to = $range_date[1];    
                
                    if ($day_from !== '') {
                        $from = date("Y-m-d",strtotime($day_from));
                        $query->where('user.'.$column,'>=',$from);
                    }
                    if ($day_to !== '') {
                        $to = date("Y-m-d",strtotime($day_to));
                        $query->where('user.'.$column,'<=',$to.' 23:59:59');
                    }
                } elseif ($column == 'status' || $column == 'id') {
                    $query->where('user.'.$column,$value);
                } else {
                    $query->where('user.'.$column,'LIKE','%'.$value.'%');
                }
                
            }
            
        }
        
        $total_filtered = $query->count();
        
        $orderColumn = $columns[$request['order'][0]['column']];
        if ($orderColumn == 'id' || $orderColumn == 'phone' || $orderColumn == 'name'|| $orderColumn == 'created_at' || $orderColumn == 'last_visit') {
            $query->orderBy($orderColumn,$request['order'][0]['dir']);
        } elseif($orderColumn == 'items') {
            $total_filtered = $query->has('items')->count();
            $query->has('items')
            ->withCount('items')
            ->orderBy('items_count',$request['order'][0]['dir']);
        } else {
            $total_filtered = $query->join('item','user.id','=','item.id_user')->selectRaw('count(case when item.status = "'.$orderColumn.'" then 1 else null end) as amount')->groupBy('id_user')->count();
            $query->orderBy('amount',$request['order'][0]['dir']);
        }
        $query->skip($request['start'])->take($request['length']);
        
        return [
            'users'=> $query->get(),
            'totalAmount' =>$this->count(),
            'totalFiltered' => $total_filtered
        ];
    }

    /**
     *   Count total and active users
     *   @param Request $request
     *   @return array(
     *       <pre>
     *       'total' => int,
     *       'active' => int,
     *       'date' => datetime
     *   )
    */
    public function countUserData(Request $request){
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
}
