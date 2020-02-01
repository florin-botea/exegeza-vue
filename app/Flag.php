<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
	public $timestamps = false;
		
    protected $fillable = ['name', 'value'];
	
		public function comment()
		{
			return $this->belongsTo('App\Comment', 'comment_id');
		}
	
}
