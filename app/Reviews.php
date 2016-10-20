<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{

	protected $table = 'reviews';

	protected $fillable = ['title', 'slowtitle', 'forindex', 'bodyindex', 'about', 'img_review', 'cat_id', 'user_id'];

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function category()
	{
		return $this->belongsTo('App\Categories', 'cat_id');
	}

}
