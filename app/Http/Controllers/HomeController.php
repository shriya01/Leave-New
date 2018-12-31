<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Config;
use Crypt;
use App;
use App\Leave;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;

/**
 * HomeController
 * 
 * @package                LeaveManagementSystem
 * @category               Controller
 * @DateOfCreation         23 August 2018
 * @ShortDescription       HomeController contains leave related functions at user end 
 */
class HomeController extends Controller
{
    public function __construct()
    {

    }
    /**
     * @DateOfCreation         23 August 2018
     * @ShortDescription       Display home page
     * @return                 View
     */
    public function index()
    {
        return view('home.welcome');
    }

    /**
     * @DateOfCreation         23 August 2018
     * @ShortDescription       change the language according to the input
     * @return                 Response
     */
    public function postChangeLanguage(Request $request)
    {
        \Session::put('locale', $request->input('lang'));
        return redirect()->back();
    }

    /**
     * @DateOfCreation         23 August 2018
     * @ShortDescription       Destroy the session and Make the Auth Logout
     * @return                 Response
     */
    public function getLogout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }
    
    /**
     * @DateOfCreation        17 August 2018
     * @DateOfDeprecated
     * @ShortDescription      This function show the form for creating a new leave application.
     * @LongDescription
     * @return \Illuminate\Http\Response
     */
    public function getLeave()
    {
        $leave_types = Leave::select('leave_type', ['leave_type_id', 'leave_type_name'], ['is_deleted'=>2]);
        return view("leaves.create", ['leave_types'=>$leave_types,'success'=>'']);
    }

    /**
     * @DateOfCreation        17 August 2018
     * @DateOfDeprecated
     * @ShortDescription      This function store a newly created leave application in storage.
     * @LongDescription
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLeave(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'leave_type' => 'required',
        'from_date'  => 'required|date|date_format:Y-m-d|before_or_equal:to_date',
        'to_date'    => 'required|date|date_format:Y-m-d|after_or_equal:from_date',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $leave_types = Leave::select('leave_type', ['leave_type_id', 'leave_type_name'], ['is_deleted'=>2]);
            return view("leaves.create", ['errors'=>$errors,'leave_types'=>$leave_types,'success'=>'']);
        }
        $leave_type = request()->input('leave_type');
        $leave_from_date = request()->input('from_date');
        $leave_to_date = request()->input('to_date');
        $user = Auth::user();
        if ($leave_from_date == $leave_to_date) {
            $leave_duration_day = request()->input('leave_type_day');
            $leave_slot_day = request()->input('leave_slot_day');
        }
        $insert_array =  [  'leave_type_id' => $leave_type,
        'leave_from_date'=>$leave_from_date,
        'leave_to_date' => $leave_to_date,
        'user_id'=>$user->user_id,
        'leave_duration_day'=>isset($leave_duration_day) ? $leave_duration_day : 0,
        'leave_slot_day'=> isset($leave_slot_day) ? $leave_slot_day :0
        ];
        Leave::insert('leaves', $insert_array);
        $leave_types = Leave::select('leave_type', ['leave_type_id', 'leave_type_name'], ['is_deleted'=>2]);
        return view("leaves.create", ['leave_types'=>$leave_types,'success'=>'Leave Request Dropped Successfully']);
    }

    /**
     * @DateOfCreation        27 August 2018
     * @DateOfDeprecated
     * @ShortDescription      This function shows the user leave records.
     * @LongDescription
     * @return [type] [description]
     */
    public function showUserLeaveRecords()
    {
        $id= Auth::user()->user_id;
        $leaves = Leave::showRecordsById($id);
        return view("leaves.usershow", ['leaves'=>$leaves]);
    }

    /**
     * @DateOfCreation        17 August 2018
     * @DateOfDeprecated
     * @ShortDescription      This function checks the validation on server side too .
     * @LongDescription
     * @param  Request $request [description]
     */
    public function checkValidation(Request $request)
    {
        $leave_type = $request->leave_type;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($leave_type != '' && $to_date >= $from_date) {
            echo '1';
        }
    }
}
