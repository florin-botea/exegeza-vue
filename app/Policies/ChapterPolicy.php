<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChapterPolicy
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
		return $user->hasRole('admin');
	}

	public function update(){
		return $user->hasRole('admin');
	}

	public function delete(){
		return $user->hasRole('admin');
	}	
}
