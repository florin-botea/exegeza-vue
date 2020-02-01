<?php

namespace App\Policies;

use App\User;
use App\ModelHasTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModelHasTagPolicy
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
		return $user->can('add tags') || \App\Comment::findOrFail( request()->get('comment_id') )->author === $user->id;
	}

	public function delete(User $user, ModelHasTag $tag){
		return $user->can('delete tags') || $tag->assigned_by === $user->id;
	}	
}
