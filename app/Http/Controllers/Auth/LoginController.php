<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Users;
use Config;
use App;

/**
 * LoginController
 * 
 * @package                LeaveManagementSystem
 * @category               Controller
 * @DateOfCreation         23 August 2018
 * @ShortDescription       LoginController contains user login related functions 
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->userobj = new Users;
    }
    /**
     * @DateOfCreation         22 August 2018
     * @ShortDescription       Load the login view
     * @return                 View
     */
    public function getLogin()
    {
        return view('home.login');
    }
    /**
     * @DateOfCreation         22 August 2018
     * @ShortDescription       Handle a login request to the application
     * @param1                 App\Http\Requests\LoginRequest  $request
     * @return                 Response
     */
    public function postLogin(Request $request)
    {
        $rules = array(
            'user_email' => 'required',
            'password' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {
            $inputData = array(
                'user_email'=>$request->input('user_email'),
                'password'=>$request->input('password'),
                'user_role_id'=> Config::get('constants.USER_ROLE')
            );
        }
        if (Auth::attempt($inputData)) {
            return redirect("/")->with(array("message"=>__('messages.login_success')));
        } else {
            $checkData = ['user_email'=> $inputData['user_email'],'user_role_id'=>Config::get('constants.USER_ROLE')];
            if ($this->userobj->countRecords($checkData)) {
                $validator->getMessageBag()->add('password', __('messages.wrong_password'));
            } else {
                $validator->getMessageBag()->add('user_email', __('messages.account_not_exist'));
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}
