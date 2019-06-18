<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\passRequest;
use App\Employee;
use App\Item;
use App\User;
use Illuminate\Support\Facades\Auth;   
use Hash; 
use validator;
use DB;
class UserController extends Controller
{	
	
    /**
     * render view change pass
     *
     * @return view('auth.passwords.changePass');
     */
    public function editPassword(){
    	return view('auth.passwords.changePass');
    }
     /**
     * Update the password of user.
     *
     * @param  \Illuminate\Http\Request  $request
     * s
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(passRequest $request){
 
    
    	$user = Auth::user();
    	$oldPassword = $request['passwordold'];
        $newPassword = $request['password'];

        if (Hash::check($oldPassword, $user->password)) {
            $request->user()->fill(['password'=>Hash::make($newPassword)])->save();
            return redirect()->action('ItemsController@index');
        }
        else
        {
         	return redirect()->back()->with('alert','Thay  đổi không thành công');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
}
