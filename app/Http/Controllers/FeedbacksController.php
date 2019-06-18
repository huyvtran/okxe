<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Feedback;

class FeedbacksController extends Controller
{
    private $feedback_model;

    public function __construct(){
        $this->feedback_model = new Feedback();
    }

    /**
     * Display a listing of the resource.
     *
     * @return view('admin.feedbacks')
     */
    public function index(){
        $rates = $this->feedback_model->rates;
        $statuses = $this->feedback_model->statuses;
        return view('admin.feedbacks',compact('rates','statuses'));
    }

    /**
     * 
     * @param Request $request
     * @return redirect()->back()
     */

    public function changeStatus(Request $request){
        $msg = '';
        if($request->has('checkBoxArray')){
            $feedbacks = Feedback::findorFail($request->checkBoxArray);
            if($feedbacks){
                foreach($feedbacks as $feedback){
                    $feedback->update(['status'=>$request->checkBoxes]);
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
        $tableName = 'feedback';
        $columns = array('id', 'phone', 'name', 'content', 'rating', 'contactable', 'status', 'created_at');
        $rows = implode(',',[$tableName.'.id',$tableName.'.title',$tableName.'.id_user',$tableName.'.content',$tableName.'.status',$tableName.'.rating',$tableName.'.contactable',$tableName.'.created_at']);
        $data = $this->feedback_model->filter($request,$rows,$columns,$tableName);
        $feedbacks = [];
        if($data['feedbacks']){
            foreach($data['feedbacks'] as $feedback)
            {   
                array_push($feedbacks,
                [
                'id'=> $feedback->id,
                'phone'=> $feedback->user ? $feedback->user->phone : "",
                'name'=> $feedback->user ? $feedback->user->name : "",
                'content'=> $feedback->content ? $feedback->content : "",
                'rating'=> $feedback->rating ? $feedback->rating : "",
                'contactable' => $feedback->contactable == 2 ? '<i class="fa fa-check active" aria-hidden="true"></i>' : '<i class="fa fa-times ban" aria-hidden="true"></i>',
                'status'=> $feedback->status ? $feedback->status : "",
                'created_at'=> $feedback->created_at ? $feedback->created_at->format('m/d/Y') : "",
                'checkbox' => '<input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="'.$feedback->id.'">'
                ]);
            }
        }
        return response()->json(array(
			"draw"            => (int) $request['draw'] ,   
			"recordsTotal"    => (int) $data['totalData'] ,  
			"recordsFiltered" => (int) $data['totalFiltered'] ,
			"data"            => $feedbacks   
			));
    }
}
