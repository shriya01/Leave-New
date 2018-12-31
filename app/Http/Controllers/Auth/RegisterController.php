<?php

namespace App\Http\Controllers\Auth;

use App\Users;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Config;

/**
 * RegisterController
 * 
 * @package                LeaveManagementSystem
 * @category               Controller
 * @DateOfCreation         23 August 2018
 * @ShortDescription       RegisterController contains user registration related functions 
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
        $this->userobj = new Users;
    }

    /**
     * @DateOfCreation         22 August 2018
     * @ShortDescription       Load the register view
     * @return                 View
     */
    public function getRegister()
    {
        return view('home.register');
    }

    /**
     * @DateOfCreation         22 August 2018
     * @ShortDescription       Handle a register request to the application
     * @param1                 App\Http\Requests\LoginRequest  $request
     * @return                 Response
     */
    public function postRegister(Request $request)
    {
        $rules = array(
            'first_name'    => 'required|min:3|max:50',
            'last_name'     => 'required|min:3|max:50',
            'user_email'     => 'required|email|unique:users',
            'password'  => 'required',
            'confirm_password' => 'required|same:password'
        );
        // set validator
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // redirect our user back to the form with the errors from the validator
            return redirect()->back()->withInput()->withErrors($validator->errors());
        } else {
            //final array of the data from the request
            $userData = array(
                'user_first_name' => $request->input("first_name"),
                'user_last_name' => $request->input("last_name"),
                'user_role_id' => Config::get('constants.USER_ROLE'),
                'user_email' => $request->input("user_email"),
                'password' => bcrypt($request->input("password")),
                'user_created_at' => date('Y-m-d H:i:s'),
                'user_updated_at'   => date('Y-m-d H:i:s'),
                'user_status' => Config::get('constants.ACTIVE_STATUS')
            );
            //insert user data in users table
            $user = $this->userobj->storeData($userData);
            if ($user) {
                return redirect('/login')->with('message', __('messages.registration_successfull'));
            } else {
                return redirect()->back()->withInput()->withErrors(__('messages.try_again'));
            }
        }
    }
}
