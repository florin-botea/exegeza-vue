<?php

namespace App\Listeners;

use App\Events\CommentAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class AssignFlagPermission
{
	public function __construct(){
		
	}
	
    public function handle(CommentAdded $event)
    {
		if (! Auth::user()->can('flag comments') ){
			$permission = Permission::firstOrCreate(['name' => 'flag comments']);
			Auth::user()->givePermissionTo($permission);
			\Notification::send( Auth::user(), new \App\Notifications\OnNewPermission('flag comments'));
		}
    }
}
