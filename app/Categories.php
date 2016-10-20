<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{

	public function review()
	{
		return $this->belongsTo('App\Reviews');
	}

}