<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Admins;
use App\Users;
use App\Leave;
use Config;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Hash;
use Excel;

/**
 * DashboardController
 *
 * @package                LeaveManagementSystem
 * @category               Controller
 * @DateOfCreation         23 August 2018
 * @ShortDescription       DashboardController contains user CRUD and Leave related operation functions
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->adminobj = new Admins;
        $this->userobj  = new Users;
    }

    /**
     * @DateOfCreation         23 August 2018
     * @ShortDescription       Load the dashboard view
     * @return                 View
     */
    public function index()
    {
        /**
         * @ShortDescription Blank array for the count for sending the array to the view.
         *
         * @var Array
         */
        $count = [];
        $count['users']  = $this->adminobj->countRecords(['user_role_id'=>Config::get('constants.USER_ROLE')]);
        return view('admin.dashboard', compact('count'));
    }

    /**
     * @DateOfCreation         23 August 2018
     * @ShortDescription       Load users view with list of all users
     * @return                 View
     */
    public function users()
    {
        /**
         * @ShortDescription Blank array for the data for sending the array to the view.
         *
         * @var Array
         */
        $data = [];
        $data['users'] = $this->adminobj->getRecordsWhereKeyIsNotInArray('user_role_id', [Config::get('constants.ADMIN_ROLE')]);
        return view('admin.users', $data);
    }

    /**
     * @DateOfCreation         27 August 2018
     * @ShortDescription       This Function run according to the parameter if $user_id is NUll
     *                          then it return add view If it get ID it will return edit view
     * @return                 View
     */
    public function getUser($user_id = null)
    {
        if (!empty($user_id)) {
            try {
                $id = Crypt::decrypt($user_id);
                $check = $this->userobj->countRecords(['user_id' =>$id]);
                if (is_int($id) && $check > 0) {
                    $data['user'] = $this->userobj->retrieveRecord($id);
                    return view('admin.editUser', $data);
                } else {
                    return redirect()->back()->withErrors(__('messages.Id_incorrect'));
                }
            } catch (DecryptException $e) {
                return view("admin.errors");
            }
        } else {
            return view('admin.addUser');
        }
    }
    
    /**
     * @DateOfCreation         27 August 2018
     * @ShortDescription       This function handle the post request which get after submit the
     *                         and function run according to the parameter if $user_id is NUll
     *                         then it will insert the value If it get ID it will update the value
     *                         according to the ID
     * @return                 Response
     */
    public function postUser(Request $request, $user_id = null)
    {
        $rules = array(
            'user_firstname' => 'required|max:50',
            'user_lastname' => 'required|max:500',
            'user_email'=>'required|min:5|email|unique:users',
            'password'  => 'required|confirmed',
            'user_country'=>'required'
            );
        if (!empty($user_id)) {
            $id = Crypt::decrypt($user_id);
            $rules = array(
                'user_firstname' => 'required|max:50',
                'user_lastname' => 'required|max:500',
                'user_email' => 'email|unique:users,user_email,'.$id.',user_id'
                );
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        } else {
            if (empty($user_id)) {
                $insertData = array(
                    'user_first_name' => $request->input('user_firstname'),
                    'user_last_name' => $request->input('user_lastname'),
                    'user_email'=> $request->input('user_email'),
                    'user_country' => $request->input('user_country'),
                    'password'  => Hash::make($request->input('password')),
                    'user_role_id' => Config::get('constants.USER_ROLE'),
                    'user_updated_at'=>date('Y-m-d'),
                    'user_status'=>1
                    );
                $user = $this->userobj->storeData($insertData);
                if ($user) {
                    return redirect('adminUsers')->with('message', __('messages.Record_added'));
                } else {
                    return redirect()->back()->withInput()->withErrors(__('messages.try_again'));
                }
            } else {
                $id = Crypt::decrypt($user_id);
                $updateData = array(
                    'user_first_name' => $request->input('user_firstname'),
                    'user_last_name' => $request->input('user_lastname'),
                    'user_email'=> $request->input('user_email'),
                    'user_country' => $request->input('user_country'),

                    );
                if (is_int($id)) {
                    $user = $this->userobj->updateData(array('user_id' => $id), $updateData);
                    return redirect('adminUsers')->with('message', __('messages.Record_updated'));
                } else {
                    return redirect()->back()->withInput()->withErrors(__('messages.try_again'));
                }
            }
        }
    }

    /**
     * @DateOfCreation         27 August 2018
     * @ShortDescription       Get the ID from the ajax and pass it to the function to delete it
     * @return                 Response
     */
    public function deleteUser(Request $request)
    {
        try {
            $id = Crypt::decrypt($request->input('id'));
            if (is_int($id)) {
                $user = $this->userobj->retrieveRecordOrTerminate($id);
                if ($user->delete()) {
                    return Config::get('constants.OPERATION_CONFIRM');
                } else {
                    return Config::get('constants.OPERATION_FAIED');
                }
            } else {
                return Config::get('constants.ID_NOT_CORRECT');
            }
        } catch (DecryptException $e) {
            return Config::get('constants.ID_NOT_CORRECT');
        }
    }

    /**
     * @DateOfCreation        27 August 2018
     * @DateOfDeprecated
     * @ShortDescription      This function displays the specified leave application
     * @LongDescription
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $leaves = Leave::showRecordsById($id);
        return view("leaves.show", ['leaves'=>$leaves]);
    }

    /**
     * @DateOfCreation        30 August 2018
     * @DateOfDeprecated
     * @ShortDescription      This function allow admin to add leave record directly if
     *                        corresponding user is not capable to apply leave for any reason
     * @LongDescription
     * @return \Illuminate\Http\Response
     */
    public function getLeave($id)
    {
        $id = Crypt::decrypt($id);
        $leave_types = Leave::select('leave_type', ['leave_type_id', 'leave_type_name'], ['is_deleted'=>2]);
        return view("admin.addLeave", ['leave_types'=>$leave_types,'success'=>'','id'=>$id]);
    }

    /**
     * @DateOfCreation        30 August 2018
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
            'from_date'  => 'required|date|before_or_equal:to_date',
            'to_date'    => 'required|date|after_or_equal:from_date',
            ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $users = $this->adminobj->getRecordsWhereKeyIsNotInArray('user_role_id', [1]);
            $leave_types = Leave::select('leave_type', ['leave_type_id', 'leave_type_name'], ['is_deleted'=>2]);
            return view("admin.addLeave", ['leave_types'=>$leave_types,'errors'=>$errors,'success'=>'','users'=>$users]);
        }
        $user_id = Crypt::decrypt(request()->input('user_id'));
        $leave_type = request()->input('leave_type');
        $leave_from_date = request()->input('from_date');
        $leave_to_date = request()->input('to_date');
        if ($leave_from_date == $leave_to_date) {
            $leave_duration_day = request()->input('leave_type_day');
            $leave_slot_day = request()->input('leave_slot_day');
            $leave_from_time =  request()->input('from_time');
            $leave_to_time =  request()->input('to_time');
        }

        $insert_array =  [  'leave_type_id' => $leave_type,
        'leave_from_date'=>$leave_from_date,
        'leave_to_date' => $leave_to_date,
        'user_id'=>$user_id,
        'leave_duration_day'=>isset($leave_duration_day) ? $leave_duration_day : 0,
        'leave_slot_day'=> isset($leave_slot_day) ? $leave_slot_day :0,
        'leave_from_time'=>isset($leave_from_time) ? $leave_from_time : 0,
        'leave_to_time'=> isset($leave_to_time) ? $leave_to_time :0
        ];
        Leave::insert('leaves', $insert_array);
        return redirect('leaves/show/'.Crypt::encrypt($user_id))->with('message', __('Leave Request Added'));
    }
    
    /**
     * @DateOfCreation        30 August 2018
     * @DateOfDeprecated
     * @ShortDescription      This function checks the validation on server side too for admin.
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

    /**
     * @DateOfCreation        30 August 2018
     * @DateOfDeprecated
     * @ShortDescription      This function changes the leave status
     * @LongDescription
     * @param  int $id [description]
     */
    public function changeLeaveStatus(Request $request)
    {
        $id = $request->id;
        $leave_id = $request->attrid;
        $user = Leave::update('leaves', array('is_deleted'=>$id), array('leave_id' => $leave_id));
        echo '1';
    }
    /**
     * @DateOfCreation        04 September 2018
     * @DateOfDeprecated
     * @ShortDescription      export leave data to excel viewer according to type for specified id
     * @param                 [string] $type [type of file to be view on excel viewer csv,xlsx etc]
     * @param                 [int] $id
     * @return                [excel file]
     */
    public function downloadExcel(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $type = $request->file_type;
        $id = $request->user_id ? $request->user_id : null ;
        if ($id) {
            $data = Leave::filterRecordsById($id, $from_date, $to_date);
        } else {
            $data = Leave::showRecords($from_date, $to_date);
        }
        $data = json_decode(json_encode($data), true);
        return Excel::create('DataSheet', function ($excel) use ($data) {
            $excel->sheet('Sheet1', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download($type);
    }
    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importExcel(Request $request)
    {
        $validator = Validator::make(
          [
              'import_file'      => $request->import_file,
              'extension' => strtolower($request->import_file->getClientOriginalExtension()),
          ],
          [
              'import_file'          => 'required',
              'extension'      => 'required|in:csv,xlsx,xls',
          ]
        );
        if ($validator->fails()) {
            return back()->with('import_error', 'File Is Required And it Should be xls or csv.');
        }
        $path = $request->file('import_file')->getRealPath();
        $data = Excel::load($path)->get();
        $i = 0;
        $array = [];
        if ($data->count()) {
            foreach ($data as $key => $value) {
                $arr = ['user_id' => $value->user_id,'leave_type_id' =>$value->leave_type_id,
                'leave_duration_day'=>$value->leave_duration_day,'leave_slot_day'=>$value->leave_slot_day,'leave_from_date'=>$value->leave_from_date,'leave_to_date'=>$value->leave_to_date];
                if (!empty($arr)) {
                    $leave_records = Leave::select('leaves', ['user_id','leave_from_date','leave_to_date'], ['user_id'=>$value->user_id,'leave_from_date'=>$value->leave_from_date,'leave_to_date'=>$value->leave_to_date]);
                    if (count($leave_records) == 0) {
                        Leave::insert('leaves', $arr);
                    } else {
                        $j = $i+1;
                        $string = "On Excel Record Number ".$j." For User ID ".$value->user_id." From Date ".$value->leave_from_date." To Date".$value->leave_to_date." Leave Already Applied";
                        array_push($array, $string);
                    }
                }
                $i++;
            }
        }
        $import_success = 'File Imported And Insert Record successfully.';
        return back()->with(['import_success'=>$import_success,'error_array'=>$array]);
    }

    /**
     * @DateOfCreation      02 January 2019 
     * @ShortDescription    This function display form to add leave type
     *
     */
    public function getLeaveType($id = null){
        $data = [];
        if(!empty($id))
        {
            $id = Crypt::decrypt($id);
            $leave_types = Leave::select('leave_type', ['leave_type_id', 'leave_type_name'], ['leave_type_id'=>$id,'is_deleted'=>2]);
            foreach ($leave_types as $key) 
            {
                $data['leave_type_id'] = $key->leave_type_id;
               $data['leave_type_name'] =$key->leave_type_name;
            }
         }
       return view("admin.addLeaveType",$data);
    }

    /**
     * @DateOfCreation         02 January 2019
     * @ShortDescription       This function save the new leave type into the database
     * @return                 View
     */
    public function postLeaveType(Request $request){
        $rules = ['leave_type_name' => 'required|unique:leave_type'];
        if(!empty(request()->leave_type_id))
        {
            $id =  Crypt::decrypt(request()->leave_type_id);
        if(!empty($id))
        {   
            $rules['leave_type_name'] = 'required|unique:leave_type,leave_type_name,'.$id.',leave_type_id';
        }
        $validator = Validator::make($request->all(),
            $rules,
            ['leave_type_name.required' => 'Leave Type Field Is Required',
             'leave_type_name.unique' => 'Leave Type Name Already Exists In Database']
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
 
      
        }
          $leave_type_name =  request()->leave_type_name;
        $insert_array =  [ 'leave_type_name' => $leave_type_name ];
        if(!empty($id)){
            Leave::update('leave_type',$insert_array,['leave_type_id'=>$id]);
            return redirect('leaveTypes')->with('message', __('Leave Type Updated'));
        }
        else{
            Leave::insert('leave_type', $insert_array);
            return redirect('leaveTypes')->with('message', __('Leave Type Added'));
        }
        
    }

    /**
     * @DateOfCreation         02 January 2019
     * @ShortDescription       This function displays the availble leave types
     * @return                 View
     */
    public function leaveTypes()
    {
        /**
         * @ShortDescription Blank array for the data for sending the array to the view.
         *
         * @var Array
         */
        $data = [];
        $data['leaveTypes'] = Leave::select('leave_type',['leave_type_id','leave_type_name']);
        return view('admin.leaveTypes', $data);
    }

    /**
     * @DateOfCreation         27 August 2018
     * @ShortDescription       Get the ID from the ajax and pass it to the function to delete it
     * @return                 Response
     */
    public function deleteLeaveType(Request $request)
    {
        try {
            $id = Crypt::decrypt($request->input('id'));
            if (is_int($id)) {
                $user = Leave::delete('leave_type', ['leave_type_id'=>$id]);
                echo $user;
                die;
                if ($user) {
                    return Config::get('constants.OPERATION_CONFIRM');
                } else {
                    return Config::get('constants.OPERATION_FAIED');
                }
            } else {
                return Config::get('constants.ID_NOT_CORRECT');
            }
        } catch (DecryptException $e) {
            return Config::get('constants.ID_NOT_CORRECT');
        }
    }
}
