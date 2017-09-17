<?php
/**
 * Created by PhpStorm.
 * User: aym14
 * Date: 16/09/2017
 * Time: 2:10
 */

class Budget extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'budgets';
    protected $fillable = ['title', 'description', 'category', 'status', 'user'];
}