<?php
/**
 * Created by PhpStorm.
 * User: aym14
 * Date: 14/09/2017
 * Time: 22:59
 */

class User extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'users';
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'address'];

}