<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bible extends Model
{
    public $timestamps = false;
		
		protected $fillable = ['name', 'alias', 'slug', 'public'];
		
		public function books()
		{
			return $this->hasMany('App\Book', 'bible_id');
		}
}
