<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Comment extends Model
{
	use LogsActivity;
	
	protected static $logAttributes = ['title', 'text'];
	
	protected static $recordEvents = ['updated', 'deleted'];
	
	protected static $logOnlyDirty = true;
	
	protected $fillable = ['target', 'author', 'title', 'text'];

	public function replies()
	{
		return $this->hasMany('App\Reply', 'comment_id');
	}
	
	public function tags()
	{
		return $this->hasMany('App\ModelHasTag', 'comment_id');
	}
	
	public function user_flag()
	{
		return $this->hasOne('App\ModelHasFlag', 'comment_id');
	}
	
	public function flags()
	{
		return $this->hasMany('App\ModelHasFlag', 'comment_id');
	}
	
	public function flag_records()
	{
		return $this->hasMany('App\FlagRecords', 'comment_id');
	}
	
	public function repports()
	{
		return $this->hasMany('App\Repport', 'model_id')->where('model_type', __CLASS__);
	}
	
	public function repportedByMe()
	{
		return $this->hasOne('App\Repport', 'model_id')->where(['model_type' =>  __CLASS__, 'repported_by' => auth()->id()]);
	}

	public function author()
	{
		return $this->belongsTo('App\User', 'author');
	}
}
