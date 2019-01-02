<?php

namespace App;

use Illuminate\Support\Facades\DB;

/**
 * User Class
 *
 * @package
 * @subpackage            User
 * @category              Model
 * @DateOfCreation        17 August 2018
 * @DateOfDeprecated
 * @ShortDescription      This class contains basic database operation related functions using laravel db facade
 * @LongDescription
 */

class Leave
{
    /**
     * @DateOfCreation       17 August 2018
     * @DateOfDeprecated
     * @ShortDescription     This function selects the specified data from table
     * @LongDescription
     * @param  string $table_name
     * @param  array  $select_array
     * @param  array  $where_array
     * @return [object]               [StdClass result object]
     */
    public static function select($table_name = '', $select_array = [], $where_array = [])
    {
        $result = DB::table($table_name)->select($select_array)->where($where_array)->get();
        return $result;
    }
    /**
     * @DateOfCreation       17 August 2018
     * @DateOfDeprecated
     * @ShortDescription     This function insert the specified data into table
     * @LongDescription
     * @param  string $table_name
     * @param  array  $insert_array
     * @return void
     */
    public static function insert($table_name = '', $insert_array = [])
    {
        return DB::table($table_name)->insertGetId($insert_array);
    }
    /**
     * @DateOfCreation       17 August 2018
     * @DateOfDeprecated
     * @ShortDescription     This function update the specified data into table
     * @LongDescription
     * @param  string $table_name
     * @param  array  $update_array
     * @param  array  $where_array
     * @return void
     */
    public static function update($table_name = '', $update_array = [], $where_array = [])
    {
        return DB::table($table_name)->where($where_array)->update($update_array);
    }
    /**
     * @DateOfCreation       27 August 2018
     * @DateOfDeprecated
     * @ShortDescription     This function show the record of specified id
     * @LongDescription
     * @param  string  $id   Encrypted id
     * @param  string $min_from_date [Starting Date Of Record Selection]
     * @param  string $max_from_date [End Date Of Record Selection]
     * @return void
     */
    public static function showRecordsById($id)
    {
        return DB::table('leaves')
            ->join('leave_type', 'leaves.leave_type_id', '=', 'leave_type.leave_type_id')
            ->rightJoin('users', 'users.user_id', '=', 'leaves.user_id')
            ->select('leave_id', 'leave_type_name', 'users.user_id', 'user_first_name', 'user_last_name', 'leave_from_date', 'leave_to_date', 'leaves.is_deleted as status', 'leave_duration_day', 'leave_slot_day')
            ->where('users.user_id', $id)
            ->orderBy('leave_id', 'DESC')
            ->get();
    }
    /**
     * @DateOfCreation       27 August 2018
     * @DateOfDeprecated
     * @ShortDescription     This function show the record of specified id from table between specified date
     * @LongDescription
     * @param  string  $id   Encrypted id
     * @param  string $min_from_date [Starting Date Of Record Selection]
     * @param  string $max_from_date [End Date Of Record Selection]
     * @return void
     */
    public static function filterRecordsById($id, $min_from_date = '2010-01-01', $max_from_date = '2099-12-01')
    {
        $min_from_date = $min_from_date ? $min_from_date : '2010-01-01';
        $max_from_date = $max_from_date ? $max_from_date : '2099-01-01';

        return DB::table('leaves')
            ->join('leave_type', 'leaves.leave_type_id', '=', 'leave_type.leave_type_id')
            ->rightJoin('users', 'users.user_id', '=', 'leaves.user_id')
            ->select('leave_id', 'leave_type_name', 'leaves.user_id', 'user_first_name', 'user_last_name', 'leave_from_date', 'leave_to_date', 'leaves.is_deleted as status', 'leave_duration_day', 'leave_slot_day')->where('users.user_id', $id)->where('leave_from_date', '>=', $min_from_date)->where('leave_from_date', '<=', $max_from_date)
            ->orderBy('leave_id', 'DESC')
            ->get();
    }
    /**
     * @DateOfCreation       7 September 2018
     * @DateOfDeprecated
     * @ShortDescription     This function show all records between specified date
     * @LongDescription
     * @param  string $min_from_date [Starting Date Of Record Selection]
     * @param  string $max_from_date [End Date Of Record Selection]
     * @return void
     */
    public static function showRecords($min_from_date = '2010-01-01', $max_from_date = '2099-12-01')
    {
        return DB::table('leaves')
            ->join('leave_type', 'leaves.leave_type_id', '=', 'leave_type.leave_type_id')
            ->rightJoin('users', 'users.user_id', '=', 'leaves.user_id')
            ->select('leave_id', 'leave_type_name', 'leaves.user_id', 'user_first_name', 'user_last_name', 'leave_from_date', 'leave_to_date', 'leaves.is_deleted as status', 'leave_duration_day', 'leave_slot_day')->where('leave_from_date', '>=', $min_from_date)->where('leave_from_date', '<=', $max_from_date)
            ->orderBy('leave_id', 'DESC')
            ->get();
    }

    public static function delete($table_name,$where_array)
    {
       return DB::table($table_name)->where($where_array)->delete();
    }
}
