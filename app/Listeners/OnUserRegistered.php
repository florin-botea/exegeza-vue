<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \App\Classes\Notification;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class OnUserRegistered
{
		
	private $notifications;
	
	public function __construct(Notification $notificator){
		$this->notifications = $notificator;
	}
		
    public function handle(UserRegistered $event)
    {
		$post_comments = Permission::firstOrCreate(['name' => 'post comments']);
		$post_replies = Permission::firstOrCreate(['name' => 'post replies']);
		if ( \App\User::count() <= 1 ){
			$admin = Role::firstOrCreate(['name' => 'admin']);
			$event->user->assignRole($admin);
		}
		$event->user->givePermissionTo([$post_comments, $post_replies]);
		\Notification::send( $event->user, new \App\Notifications\Welcome($event->user));
    }
}
