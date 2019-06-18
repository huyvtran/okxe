<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Brand;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class BrandsController extends Controller
{
    private $brand_model;

    public function __construct(){
        $this->brand_model = new Brand();
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $employees = Employee::all();
        return view('admin.brands',compact('employees'));
    }

     /**
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){
        $item = Brand::find($request->id);
        $msg = '';
        $stt = '';
        if(!count($item->models)){
            $item->delete() ? ($msg = trans('label.deleted') && $stt = true) : ($msg = trans('label.upd_err') && $stt = false) ;
        }
        else{
            $msg = trans('label.cannot_del');
            $stt = false ;
        }
        return response(['msg' => $msg, 'status' => $stt]);
    }

    /**
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request){
        $item = Brand::find($request->id);
        $msg = '';
        $stt = '';
        if($item){
            $item->update(['active'=>$request->status]) ? ($msg = trans('label.success') && $stt = true) : ($msg = trans('label.upd_err') && $stt = false) ;
        }
        else{
            $msg = trans('label.upd_err') && $stt = false ;
        }
        return response(['msg' => $msg, 'status' => $stt]);
    }

    /**
     *
     * @param  Request $request
     * @param  Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request,Brand $brand){
        $user = Auth::user();
        $msg = '';
        $stt = '';
        $exists = $brand->whereRaw("`name` = '$request->name'")->first();
        if(!$exists){
            $stt = ($user->brands()->create($request->all())) ? true : false;
            $msg = trans('label.add_brand_success');
        }else{
            $stt = false;
            $msg = trans('label.name_exist');
        }
        return response(['msg' => $msg,'stt'=>$stt]);
    }

    /**
     *
     * @param  Request $request
     * @param  Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Brand $brand){
        $item = Brand::find($request->id);
        $exists = $brand->whereRaw("`name` = '$request->value'")->first();
        $msg = '';
        $stt = '';
        if($item){
            if(!$exists){
                ($item->update(['name'=> $request->value])) ? ($stt = true) : ($msg = trans('label.upd_err') && $stt = false) ;
            }else{
                $msg = $msg = trans('label.name_exist');
                $stt = false;
            }
        }
        else{
            $msg = trans('label.upd_err');
            $stt = false;
        }
        return response(['msg' => $msg, 'status' => $stt]);
    }

    /**
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request){
        $tableName = 'brand';
        $columns = array('id', 'name', 'id_employee', 'created_at', 'active');
        $rows = implode(',',[$tableName.'.id',$tableName.'.name',$tableName.'.id_employee',$tableName.'.created_at',$tableName.'.active']);
        $data = $this->brand_model->filter($request,$rows,$columns,$tableName);
        $brands = [];
        if($data['brands']){
            foreach($data['brands'] as $brand)
            {   
                array_push($brands,
                [
                'id'=> $brand->id,
                'name'=> $brand->name ? '<span class="brand_name" data-id="'.$brand->id.'">'.$brand->name.'</span>' : "",
                'id_employee'=> $brand->employee ? $brand->employee->name : "",
                'created_at'=> $brand->created_at ? $brand->created_at->format('m/d/Y') : "",
                'active'=> $brand->active ? '<i class="fa fa-check action active" aria-hidden="true"></i>' : '<i class="fa fa-times action ban" aria-hidden="true"></i>' ,
                'checkbox' => '<i class="fa fa-trash-o delete ban" aria-hidden="true" value="'.$brand->id.'"></i>'
                ]);
            }
        }
        return response()->json(array(
			"draw"            => (int) $request['draw'] ,   
			"recordsTotal"    => (int) $data['totalData'] ,  
			"recordsFiltered" => (int) $data['totalFiltered'] ,
			"data"            => $brands   
        ));
    }
    
}
