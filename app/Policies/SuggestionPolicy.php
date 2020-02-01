<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Suggestion;

class SuggestionPolicy
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
	}

	public function update(User $user, Suggestion $suggestion){
		//return $user->can('update replies') || $reply->author === $user->id;
	}

	public function delete(User $user, Suggestion $suggestion){
		return $user->can('delete suggestions');
	}	
}
