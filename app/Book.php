<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	public $timestamps = false;
	
	protected $fillable = ['bible_id', 'name', 'index', 'slug'];
	
	public function chapters()
	{
		return $this->hasMany('App\Chapter', 'book_id');
	}
	
	public function chapter()
	{
		return $this->hasOne('App\Chapter', 'book_id');
	}
}