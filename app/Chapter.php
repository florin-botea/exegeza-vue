<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
	public $timestamps = false;
	
	protected $fillable = ['index', 'text'];
	
	public function verses()
	{
		return $this->hasMany('App\Verse', 'chapter_id');
	}
	
	public function verse()
	{
		return $this->hasOne('App\Verse', 'chapter_id');
	}
	
	public function book()
	{
		return $this->belongsTo('App\Book', 'book_id');
	}
}
