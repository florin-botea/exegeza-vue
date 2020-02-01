<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Reply;

class ReplyPolicy
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
		return $user->can('post replies') || \App\Comment::findOrFail( request()->get('comment_id') )->author === $user->id;
	}

	public function update(User $user, Reply $reply){
		return $user->can('update replies') || $reply->author === $user->id;
	}

	public function delete(User $user, Reply $reply){
		return $user->can('delete replies') || $reply->author === $user->id;
	}	
}
