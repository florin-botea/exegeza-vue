<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('flags')) {
			Schema::create('flags', function (Blueprint $table) {
					$table->increments('id');
					$table->string('name');
					$table->integer('value');
			});
		}
		if (!Schema::hasTable('model_has_flags')) {
			Schema::create('model_has_flags', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('flag_id')->unsigned();
					$table->foreign('flag_id')
						->references('id')
						->on('flags');
					$table->integer('comment_id')->unsigned();
					$table->foreign('comment_id')
						->references('id')
						->on('comments')
						->onDelete('cascade');
					$table->integer('author')->length(11);
					$table->timestamps();
			});
		}
		if (!Schema::hasTable('flag_records')) {
			Schema::create('flag_records', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('comment_id')->unsigned();
					$table->foreign('comment_id')
						->references('id')
						->on('comments')
						->onDelete('cascade');
					$table->integer('flag_id')->unsigned();
					$table->foreign('flag_id')
						->references('id')
						->on('flags');
					$table->integer('count')->length(11);
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
		Schema::dropIfExists('model_has_flags');
		Schema::dropIfExists('flag_records');
        Schema::dropIfExists('flags');
    }
}
