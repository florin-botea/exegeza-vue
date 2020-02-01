<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Traits\BindsDynamically;

class Verse extends Model
{
	use BindsDynamically;

	public $timestamps = false;
	
	protected $fillable = ['id', 'index', 'text'];
	
	public function chapter (){
		return $this->belongsTo('App\Chapter', 'chapter_id');
	}
	
	public function book($version){
		$this->bind('connection', 'v_1_verses'); 
		return $this->hasOne('App\Book', 'index', 'book_index');
	}
}
