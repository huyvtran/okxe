<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Item;
use App\User;

class ChartsController extends Controller
{
    /**
     * Display the dashboard page.
     * 
     * @return \Illuminate\Http\Response
    */
    public function showDashboard(){
        return view('admin.dashboard');
    }

    /**
     * Get the specified amount of items
     * 
     * @return int
    */
    public function getLimitItem(){
        return 10;
    }

    /**
     * Get the data from database.
     * @param  Request $request
     * @param  Item $item
     * @param  User $user
     * @return \Illuminate\Http\Response
    */
    public function getData(Request $request,Item $item,User $user){
        $data = [];
        array_push($data,[
            'items' => $item->countItemData($request),
            'accounts' => $user->countUserData($request)
        ]);
        return response()->json($data);
    }

    /**
     * Get the statistics from database.
     * @param  Request $request
     * @param  Item $item
     * @return \Illuminate\Http\Response
    */
    public function getStatistics(Request $request,Item $item){
        $data = [];
        $tables = [['on'=>'id_province','table'=>'province'],['on'=>'id_brand','table'=>'brand'],['on'=>'id_model','table'=>'model'],['on'=>'id_user','table'=>'user']];
        foreach($tables as $table){
            array_push($data,$item->getItemStatistics($request,$table,$this->getLimitItem()));
        }
        return view('admin.statisticstables',compact('data'));
    }
}