<?php

namespace App;

use App\Admin;
use Illuminate\Database\Eloquent\Model;

/**
 * Admins
 *
 * @package                LeaveManagementSystem
 * @category               Model
 * @DateOfCreation         23 August 2018
 * @ShortDescription       The model is is connected to the user table and you can perform
 *                         relevant operation with respect to this class
 */
class Admins extends Model
{
    /**
     * @DateOfCreation         23-August-2018
     * @ShortDescription       This function count records and filter according to the condition passed in where array
     * @param  [array] $whereArray [conditions to be passed into where to filter records]
     * @return this function return the no of records
     */
    public function countRecords($whereArray)
    {
        return Admin::where($whereArray)->count();
    }
    /**
     * @DateOfCreation         23-August-2018
     * @ShortDescription       This function get records where specified key not belongs to the specified array
     * @param  [key] $whereNotInArrayKey [key to match]
     * @param  [array] $whereNotInArray    [array in which we match key not exist]
     * @return [total records which satisfy the condition]
     */
    public function getRecordsWhereKeyIsNotInArray($whereNotInArrayKey, $whereNotInArray)
    {
        return Admin::whereNotIn($whereNotInArrayKey, $whereNotInArray)->get();
    }
}
