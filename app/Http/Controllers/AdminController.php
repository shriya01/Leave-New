<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Admins;
use Config;

/**
 * AdminController
 *
 * @package                LeaveManagementSystem
 * @category               Controller
 * @DateOfCreation         23 August 2018
 * @ShortDescription       AdminController contains admin login related functions
 */
class AdminController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
        $this->adminobj = new Admins;
    }

    /**
     * @DateOfCreation         22 August 2018
     * @ShortDescription       Load the login view for admin
     * @return                 Admin login view or redirect to dashboard
     */
    public function getLogin()
    {
        if (auth()->guard('admin')->user()) {
            return redirect()->route('dashboard');
        }
        return view('admin.login');
    }
    
    /**
     * @DateOfCreation         22 August 2018
     * @ShortDescription       Handle a admin login request to the application
     * @param1                 App\Http\Requests\LoginRequest  $request
     * @return                 Response
     */
    public function postLogin(Request $request)
    {
        $rules = array(
            'email' => 'required',
            'password' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {
            $inputData = array(
                'user_email' => $request->input('email'),
                'password' => $request->input('password'),
                'user_role_id' => Config::get('constants.ADMIN_ROLE')
            );
            if (Auth::guard('admin')->attempt($inputData)) {
                return redirect("/dashboard")->with(array("message"=>"Login Successful"));
            } else {
                if ($this->adminobj->countRecords(['user_email'=> $inputData['user_email'],
                        'user_role_id'=> Config::get('constants.ADMIN_ROLE')])) {
                    $validator->getMessageBag()->add('password', 'Your password is incorrect');
                } else {
                    $validator->getMessageBag()->add('email', 'Any account does not exists with this email address');
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
    }
}
