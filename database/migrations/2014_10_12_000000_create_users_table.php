<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('users')) {
			Schema::create('users', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name');
				$table->string('email')->unique();
				$table->timestamp('email_verified_at')->nullable();
				$table->string('password');
				$table->string('profile_image')->default('default.png');
				$table->rememberToken();
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('user_details')) {
			Schema::create('user_details', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('user_id')->unsigned();
				$table->foreign('user_id')
					->references('id')
					->on('users')
					->onDelete('cascade');
				$table->unsignedTinyInteger('age')->nullable();
				$table->char('gender', 3)->nullable();
				$table->text('description')->nullable();
				$table->timestamps();
			});
		}		

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_details');
    }
}
