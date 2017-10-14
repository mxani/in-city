<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
	protected $fillable=['user_id','first_name','last_name','username'];
	protected $date=['created_at','updated_at','deleted_at'];
	protected $table = 'Member';

}