<?php

namespace App\Http\Controllers\Auth;

use App\Employee;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    protected $loginPath = 'myAwesomeUrl';
    protected $redirectAfterLogout = 'admin/login';  
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
       
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'username'=>'required|max:255|unique:employee',
            'email' => 'required|email|max:255|unique:employee',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Employee::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' =>$data['username'],
            'password' => bcrypt($data['password']),
        ]);
    }
     /**
     *  overwrite login 
     *
     * @param $request
     * @return if(true){
     *      return redirect()->intended($this->redirectPath()); 
     * }
     * {
     *  return redirect()->back()
          ->withInput()
          ->withErrors([
              'login' => 'login fail.',
     * }
     */
    public function login(Request $request)
    {
      $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL )
          ? 'email'
          : 'username';
 
      $request->merge([
          $login_type => $request->input('login')
      ]);
 
      if (Auth::attempt($request->only($login_type, 'password'))) {
          return redirect('/admin/');
      }
 
      return redirect()->back()
          ->withInput()
          ->withErrors([
              'login' => trans('label.login_fail'),
      ]);
    }
}
