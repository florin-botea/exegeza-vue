<?php

namespace App\Policies;

use App\User;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
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
		return $user->can('post comments');
	}

	public function update(User $user, Comment $comment){
		return $user->can('update comments') || $comment->author === $user->id;
	}

	public function delete(User $user, Comment $comment){
		return $user->can('delete comments') || $comment->author === $user->id;
	}	
}
