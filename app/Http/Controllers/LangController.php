<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class LangController extends Controller
{
     /**
     * Switch the language
     * 
     * @return redirect()->back()
     */
    public function switchLang(Request $request)
    {
        Session::set('locale', $request->locale);
        return redirect()->back();
    }

    /**
     * Set the language of the table
     * 
     * @return \Illuminate\Http\Response
     */
    public function setTableLang(){
        $language = [
            "sProcessing"=> trans('datatables.processing')  ,
            "sEmptyTable" => trans('datatables.empty_table'),
            "sInfo" => trans('datatables.show') ." _START_ " .trans('label.to'). " _END_ ".trans('label.of')." _TOTAL_ " .trans('datatables.record') ,
            "sLengthMenu" =>   	trans('datatables.show') ." _MENU_ ". trans('datatables.record'),
            "sZeroRecords" =>  	trans('datatables.no_record'),
            "sInfoEmpty" =>      trans('datatables.show') ." 0 ".trans('label.to')." 0 ".trans('label.of')." 0 ". trans('datatables.record'),
            "sInfoFiltered"=> "(".trans('datatables.filtered') ." _MAX_ ". trans('datatables.record').")",
            "oPaginate" => [
                "sFirst" =>   trans('datatables.first'),
                "sPrevious"=> trans('datatables.prev'),
                "sNext"=>     trans('datatables.next'),
                "sLast"=>    trans('datatables.last')
            ]
        ];
        return response()->json($language);
    }
    
}