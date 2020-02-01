<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Observers\CommentObserver;
use App\Observers\ReplyObserver;
use App\Observers\TagObserver;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191);
		\App\Comment::observe(CommentObserver::class);
		\App\Reply::observe(ReplyObserver::class);
		\App\ModelHasTag::observe(TagObserver::class);

		Blade::component('components.inputs.form_group', 'formgroup');
		Blade::component('components.inputs.form_group_textarea', 'formgrouptextarea');
		Blade::component('components.buttons.buttonDelete', 'buttonDelete');
		Blade::component('components.buttons.buttonSubmit', 'buttonSubmit');
		Blade::component('components.buttons.buttonUpdate', 'buttonUpdate');
		
		//cross view shared data here
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
