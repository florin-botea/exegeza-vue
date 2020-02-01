<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
		'App\Bible' => 'App\Policies\BiblePolicy',
		'App\Book' => 'App\Policies\BookPolicy',
		'App\Chapter' => 'App\Policies\ChapterPolicy',
		\App\Comment::class => \App\Policies\CommentPolicy::class,
		\App\Reply::class => \App\Policies\ReplyPolicy::class,
		\App\User::class => \App\Policies\UserPolicy::class,
		\App\Suggestion::class => \App\Policies\SuggestionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

		view()->composer('*', function($view)
		{
			$id = Auth::id();
			if ($id != null){
				$auth = [];
				$auth['user'] = \App\User::find($id);
				if (!$auth['user']) die('No user having this ID has been found! Please contact website admin.');
				$auth['count_unread_notifications'] = count($auth['user']->unreadNotifications);
				$auth['permissions'] = $auth['user']->getAllPermissions();
				$view->with('auth', $auth);
			} else {
				$view->with('auth', null);
			}
		});
    }
}
