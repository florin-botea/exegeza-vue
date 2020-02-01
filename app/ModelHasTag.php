<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ModelHasTag extends Model
{
	use LogsActivity;
	
	protected static $recordEvents = ['deleted'];
	
    protected $fillable = ['tag_id', 'comment_id', 'assigned_by'];
		
	public function details()
	{
		return $this->hasOne('App\Tag', 'id', 'tag_id');
	}
	
	public function author()
	{
		return $this->belongsTo('App\User', 'assigned_by');
	}
	
	public function comment()
	{
		return $this->belongsTo('App\Comment', 'comment_id');
	}
}
