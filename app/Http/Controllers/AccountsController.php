<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use App\Item;
use App\User;
use App\Province;
class AccountsController extends Controller
{
    private $userModel;
   
    public function __construct(){
       $this->userModel = new User();
     }
     /**
     * @param Item $item
     * @param int $id
     * @return \Illuminate\Http\view Accountdetail
     */
    public function show(Item $item,$id){
    	try{
            $user = User::find($id);
            if($user){
                $cities = Province::all();
                $items = $item->where('id_user',$id)->count();
                $under =  $user->getTotalByStatus('Under review');
                $active =  $user->getTotalByStatus('Active');
                $inactive =  $user->getTotalByStatus('Inactive');
                $rejected =  $user->getTotalByStatus('Rejected');
                $cancelled =  $user->getTotalByStatus('Cancelled');
                $statuses = $item->statuses;
                return view('admin.accountdetail',compact('items','under','active','inactive','rejected','cancelled','cities','statuses','user'));
            }
            throw new  \Exception("Invalid ID");
    	}catch(\Exception $e){
    		echo $e->getMessage();
    	}
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = $this->userModel->statuses;
        return view('admin.accounts',compact('statuses'));
    }

    /**
    * Render an array of user info.
    *   @param array $user  
    *   @return array $list_user
    *        <pre>
    *        'users' => array(
    *            'user.id' => int
    *            'user.name' => str
    *            'user.status' => str
    *            'user.item' => int
    *            'items.status' => int
    *            'user.phone' => str,
    *            'user.last_visit' =>datetime
    *            'user.created_at' => datetime
    *       
    * 
    */
    private static function renderList($users){
        $list_user = [];
        if($users){
            foreach($users as $user)
            {
                $action = $user->status == 'Banned' ? '<label class="action active">'.trans('label.re_active').'</label>' : ($user->status == 'Active' ? '<label class="action ban">'.trans('label.ban').'</label>' : '');
                array_push($list_user,
                    [
                        'id' => '<a href="'.route('admin.accounts.detail',$user->id).'">'.$user->id.'</a>',
                        'phone'=> '<a href="'.route('admin.accounts.detail',$user->id).'">'.$user->phone.'</a>',
                        'name'=> '<a href="'.route('admin.accounts.detail',$user->id).'">'.$user->name.'</a>',
                        'items'=> $user->items ? count($user->items) : "0",
                        'underreview'=> $user->items ? $user->getTotalByStatus('Under review') : "0",
                        'active'=> $user->items ? $user->getTotalByStatus('Active') : "0",
                        'inactive'=> $user->items ? $user->getTotalByStatus('Inactive') : "0",
                        'rejected'=> $user->items ? $user->getTotalByStatus('Rejected') : "0",
                        'cancelled'=> $user->items ? $user->getTotalByStatus('Cancelled') : "0",
                        'status'=> $user->status ? $user->status : "",
                        'created_at'=> $user->created_at ? $user->created_at->format('m/d/Y H:i') : "",
                        'last_visit'=> $user->last_visit ? Carbon::parse($user->last_visit)->format('m/d/Y H:i') : "",
                        'action' => $action,
                        'checkbox' => '<input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="'.$user->id.'">',
                    ]
                );
                
            }
        
        }
        return $list_user;
    }

    /**
     * change status user 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function changeStatus(Request $req){
        $user = User::find($req->id);     
        $msg="";
        $status="";
        if($user && $action=$user->update(['status'=>$req->status])){
            ($action) ? ($msg = 'Updated status') && ($status = true) : ($msg = 'Something went wrong.Can not updated.') && ($status = false) ;         
        }else{
            $msg = 'Something went wrong.Can not updated.';
            $status = false;
        }
        return response(['msg'=>$msg,'status'=>$status]);  
    }

     /**
     * Filter datas from sever.
     * @param Request $request
     * @param Item $item
     * @return \Illuminate\Http\Response
     */
    public function getUserItems(Request $request,Item $item){
        $tableName = 'item';
        $columns = array('id', 'title', 'id_province', 'seri', 'price', 'status', 'created_at');
        $rows = implode(',',[$tableName.'.id',$tableName.'.title',$tableName.'.price',$tableName.'.status',$tableName.'.seri',$tableName.'.created_at',$tableName.'.id_province']);
        $data = $item->filter($request,$rows,$columns,$tableName);
        $list_item=[];
        if($data['items']){
            foreach($data['items'] as $item)
            {
                array_push($list_item,[
                    'id'=> $item->id,
                    'title'=> '<a href="'.route('admin.items.detail',$item->id).'">'.$item->title.'</a>',
                    'id_province' => $item->province ? $item->province->name : "",
                    'seri' => $item->seri ? $item->seri : "",
                    'price'=> $item->price ? number_format($item->price,"0",",","."):"",
                    'status'=> $item->status ? $item->status : "",
                    'created_at'=> $item->created_at ? $item->created_at->format('m/d/Y') : "",
                    'checkbox' => '<input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="'.$item->id.'">',
                ]);
            }
        }
        
        $json_data = array(
            "draw"            => intval( $request['draw'] ),   
            "recordsTotal"    => $data['totalData'],  
            "recordsFiltered" => $data['totalFiltered'],
            "data"            => $list_item   
            );

        echo json_encode($json_data); 
    }

    public function getList(Request $request){
        $data = $this->userModel->filter($request);
                 
        return response()->json(array(
			"draw"            => (int) $request['draw'] ,   
			"recordsTotal"    => (int)  $data['totalAmount'] ,  
			"recordsFiltered" => (int)  $data['totalFiltered'] ,
			"data"            => AccountsController::renderList($data['users'])
			));
    }

    /**
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request){
        $user = User::find($request->id);
        $msg = '';
        $status = '';
        if($user && $action = $user->update(['status'=>$request->status])){
            ($action) ? ($msg = trans('label.updated')) && ($status = true) : ($msg = trans('label.upd_err')) && ($status = false) ;
        }else{
            $msg = trans('label.upd_err');
            $status = false;
        }
        return response(['msg' => $msg, 'status' => $status]);
    }

    /**
     * Update a bulk of users.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function bulkUpdate(Request $request){
        $msg = '';
        if($request->has('checkBoxArray')){
            $users = User::findorFail($request->checkBoxArray);
            if($users){
                foreach($users as $user){
                    $user->update(['status'=>$request->checkBoxes]);
                }
                $msg = trans('label.updated');
            }
        }else{
            $msg = trans('label.pls_select');
        }
        return redirect()->back()->with('alert',$msg);
    }
}
