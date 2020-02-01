<?php set_time_limit(120);

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      //  $this->call(UsersTableSeeder::class);
			// factory(App\User::class, 10)->create()
				// ->each(function ($user){
					// $user->roles()->save(factory(App\RolesDefinition::class)->make());
				// });
			
			factory(App\Comments::class, 10)->create()
				->each(function ($comment){
					$comment->replies()->save(factory(App\Replies::class)->make());
				});
    }
}
