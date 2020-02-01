<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlagRecords extends Model
{
	public $timestamps = false;
		
	protected $fillable = ['comment_id', 'flag_id', 'count'];
	
	// public function comment_has_flag()
	// {
		// return $this->belongsTo('App\Comment', 'comment_id');
	// }
}