<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
* Users
*
* @package                LeaveManagementSystem
* @category               Model
* @DateOfCreation         23 August 2018
* @ShortDescription       The model is is connected to the user table and you can perform
*                         relevant operation with respect to this class
*/
class Users extends Model
{
    /**
     * @DateOfCreation         23-August-2018
     * @ShortDescription       This function stores the data
     * @param  [array] $userData [array to be inserted]
     * @return response
     */
    public function storeData($userData)
    {
        return User::create($userData);
    }
    /**
     * @DateOfCreation         23-August-2018
     * @ShortDescription       This function count records and filter according to the condition passed in where array
     * @param  [array] $whereArray [conditions to be passed into where to filter records]
     * @return this function return the no of records
     */
    public function countRecords($whereArray)
    {
        return User::where($whereArray)->count();
    }

    /**
     * @DateOfCreation         23-August-2018
     * @ShortDescription       This function either get the record or terminate end
     * @param  [id]            ID of the record to be retrieved
     * @return [object]     [user record or error]
     */
    public function retrieveRecordOrTerminate($id)
    {
        return User::findOrFail($id);
    }
    /**
     * @DateofCreation      30-August-2018
     * @param  [array] $whereArray [contains the condition when to update data]
     * @param  [array] $updateData [key value pair to update]
     * @return [object]             [result whether record is updated or not]
     */
    public function updateData($whereArray, $updateData)
    {
        return  User::where($whereArray)->update($updateData);
    }
    /**
     * @DateOfCreation         30-August-2018
     * @ShortDescription       This function either get the record
     *  @param  [int] $id [ID of the record to be retrieved ]
     * @return [object]     [user record]
     */
    public function retrieveRecord($id)
    {
        return User::find($id);
    }
    /**
     * @DateOfCreation         30-August-2018
     * @ShortDescription       This function get the records based on conditions
     * @param  array  $whereArray [conditions to be passed into where to filter records]
     * @return [object]             [records]
     */
    public function getRecords($whereArray = [])
    {
        return  User::where($whereArray)->get();
    }
}
