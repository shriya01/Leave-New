<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
/**
 * Admin
 *
 * @package                LeaveManagementSystem
 * @subpackage             Admin
 * @category               Model
 * @DateOfCreation         23 August 2018
 * @ShortDescription       The model is is connected to the user table and you can perform
 *                         relevant operation with respect to this class
 */
class Admin extends Authenticatable
{
    use Notifiable;
    
    /**
     * @ShortDescription Table for the users.
     *
     * @var String
     */
    protected $table = 'users';
    /**
     * @ShortDescription  The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_first_name','user_last_name','user_role_id','user_status','user_email', 'user_password','user_created_at',
    ];
    /**
     * @ShortDescription The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password',
    ];
     /**
      * @ShortDescription Remove the updated_at column dependency from the laravel.
      *
      * @var Boolean
      */
    public $timestamps = FALSE;

    /**
     * @ShortDescription Override the primary key in the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';
}