<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Comments extends Model
{

	protected $table = 'comments';

	public $fillable = ['body', 'review_id', 'user_id', 'to_comment_id', 'to_user_id'];

}