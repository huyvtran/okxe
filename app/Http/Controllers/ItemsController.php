<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Province;
use App\Item;

class ItemsController extends Controller{

    private $itemModel;

    public function __construct(){
        $this->itemModel = new Item();
    }

    /**
     * Display a listing of the resource.
     *
     * @return view('admin.items')
     */
    public function index(){
        $cities = Province::all();
        $statuses = $this->itemModel->statuses;
        return view('admin.items',compact('cities','statuses'));
    }

     /**
     * Update a bulk of items.
     * @param Request $request
     * @return redirect()->back()
     */

    public function bulkUpdate(Request $request){
        $msg = '';
        if($request->has('checkBoxArray')){
            $items = Item::findorFail($request->checkBoxArray);
            if($items){
                foreach($items as $item){
                    $item->update(['status'=>$request->checkBoxes]);
                }
                $msg = trans('label.updated');
            }    
        }else{
            $msg = trans('label.pls_select');
        }
        return redirect()->back()->with('alert',$msg);
        
        
    }

    /**
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request){
        $tableName = 'item';
        $columns = array('id', 'title', 'id_province', 'seri', 'price', 'status', 'created_at');
        $rows = implode(',',[$tableName.'.id',$tableName.'.title',$tableName.'.price',$tableName.'.status',$tableName.'.seri',$tableName.'.created_at',$tableName.'.id_province']);
        $data = $this->itemModel->filter($request,$rows,$columns,$tableName);
        $list_item = [];
        if($data['items']){

            foreach($data['items'] as $item)
            {   
                array_push($list_item,
                [
                'id'=> $item->id,
                'title'=> '<a href="'.route('admin.items.detail',$item->id).'">'.$item->title.'</a>',
                'id_province'=> $item->province ? $item->province->name : "",
                'seri'=> $item->seri ? $item->seri : "",
                'price'=> $item->price ? number_format($item->price,"0",",","."):"",
                'status'=> $item->status ? $item->status : "",
                'created_at'=> $item->created_at ? $item->created_at->format('m/d/Y') : "",
                'checkbox' => '<input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="'.$item->id.'">'
                ]);
            }
        
        }
            
        return response()->json(array(
			"draw"            => (int) $request['draw'] ,   
			"recordsTotal"    => (int) $data['totalData'] ,  
			"recordsFiltered" => (int) $data['totalFiltered'] ,
			"data"            => $list_item   
			));
    }
     
    /**
     * Display the specified resource.
     *
     * @param int $id  
     * 
     * @return view('admin.showDetail',compact('item'))
     */
     public function show($id,Item $items){
        try{
             $item = $items->getDetail($id);
        }
        catch(\Exception  $cant_found_the_item){
            return redirect('/admin/items')->with('alert',$cant_found_the_item->getMessage() ); 
        }
        
        return view('admin.itemdetail',compact('item'));
        }
        
    /**

     * 
     *
     * @param  Request $request
     * @return redirect->back
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $item = Item::find($request->id);
        $msg = '';
        if($item){
            ($item->update($input)) ? $msg = trans('label.updated') : $msg = trans('label.upd_err') ;
        }
        else{
            $msg = trans('label.upd_err');
        }
        return redirect()->back()->with('alert',$msg );         
    }

}
?>