<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
		public function author()
		{
				return $this->belongsTo('App\User', 'from');
		}
}
