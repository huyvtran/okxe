<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ListModel extends Model
{
    /**
    *   Filter data by specified condition
    *   @param Request $request
    *   @param array $rows
    *   @param array $columns
    *   @param string $table
    *   @return $query
    */
    public function filter(Request $request,$rows,$columns,$table){
        $status = $request['search']['value'];
        $query = $this->selectRaw($rows);
        if($id=request()->id){
            $query->where('id_user',$id);   
        }
        if ($status !== '' && $status !=="Items") { 
            $query->where('status',$status);
        }
    
        foreach($request['columns'] as $rkey=>$rvalue){
            $value = $request['columns'][$rkey]['search']['value'];
            $column  = $request['columns'][$rkey]['data'];
            if (!empty($value) || is_numeric($value)) {
                if($column == 'created_at'){
                    $range_date = explode('-',$request['columns'][$rkey]['search']['value']);
                    $day_from = $range_date[0];
                    $day_to = $range_date[1];
                    
                    if ($day_from !== '') {
                        $from = date("Y-m-d",strtotime($day_from));
                        $query->where($table.'.'.$column,'>=',$from);
                    }
                    if ($day_to !== '') {
                        $to = date("Y-m-d",strtotime($day_to));
                        $query->where($table.'.'.$column,'<=',$to.' 23:59:59');
                    }
                } elseif ($column == 'status' || $column == 'active' || $column == 'rating' || $column == 'id' || $column == 'contactable') {
                    $query->where($table.'.'.$column,$value);
                } elseif (($column == 'phone' || $column == 'name') && $table == 'feedback') {
                    if (strpos($query->toSql(), 'left join') !== false) {
                        $query->where('user.'.$column,'LIKE','%'.$value.'%');
                    }else{
                        $query->leftJoin('user',function($join){ $join->on('user.id','=','feedback.id_user'); })->where('user.'.$column,'LIKE','%'.$value.'%');  
                    }
                } else {
                    $query->where($table.'.'.$column,'LIKE','%'.$value.'%');
                }
            }
        }
        return $query;
        
    }
}