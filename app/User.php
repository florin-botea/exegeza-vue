<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable;
	use HasRoles;
	use LogsActivity;
	
	protected static $logAttributes = ['name', 'email', 'password'];
	
	protected static $recordEvents = ['updated'];
	
	protected static $logOnlyDirty = true;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
		
	public function details()
	{
		return $this->hasOne('App\UserDetails', 'user_id');
	}
	
	public function comments()
	{
		return $this->hasMany('App\Comment', 'author');
	}
}
