<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{

	protected $table = 'subscribe';

	public $fillable = ['user_id', 'from_user_id'];

}
