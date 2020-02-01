<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
	
	public function view(){
		return true;
	}
	
	public function create(User $user){
		return true;
		//return $user->can('post replies') || \App\Comment::findOrFail( request()->get('comment_id') )->author === $user->id;
	}

	public function update(User $auth, User $user){
		return $auth->id === $user->id;
	}

	public function delete(User $user, Reply $reply){
		//return $user->can('delete replies') || $reply->author === $user->id;
	}	
}
