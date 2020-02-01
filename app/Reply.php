<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Reply extends Model
{
	use LogsActivity;
	
	protected static $logAttributes = ['text'];
	
	protected static $recordEvents = ['updated', 'deleted'];
	
	protected static $logOnlyDirty = true;
	
	protected $fillable = ['comment_id', 're_reply', 'author', 'text'];
	
	public function vote()
	{
		return $this->hasMany('App\Vote', 'target');
	}
	
	public function author()
	{
		return $this->belongsTo('App\User', 'author');
	}
	
	public function comment()
	{
		return $this->belongsTo('App\Comment', 'comment_id');
	}
	
	public function repports()
	{
		return $this->hasMany('App\Repport', 'model_id')->where('model_type', __CLASS__);
	}
	
	public function repportedByMe()
	{
		return $this->hasOne('App\Repport', 'model_id')->where(['model_type' =>  __CLASS__, 'repported_by' => auth()->id()]);
	}
}
