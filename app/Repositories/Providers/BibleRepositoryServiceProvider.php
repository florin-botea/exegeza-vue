<?php
namespace App\Repositories\Providers;

use Illuminate\Support\ServiceProvider;

class BibleRepositoryServiceProvider extends ServiceProvider
{
   public function register()
   {
      $this->app->bind(
         'App\Repositories\Contracts\BibleRepositoryInterface',
         // To change the data source, replace this class name
         // with another implementation
         'App\Repositories\Eloquent\BibleRepository'
      );
   }
}