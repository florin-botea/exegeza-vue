<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('tags')) {
			Schema::create('tags', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name', 20);
				$table->integer('created_by')->length(11);
				$table->timestamps();
			});
		}
		
		if (!Schema::hasTable('model_has_tags')) {
			Schema::create('model_has_tags', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('tag_id');
				$table->integer('comment_id')->unsigned();
				$table->foreign('comment_id')
					->references('id')
					->on('comments')
					->onDelete('cascade');
				$table->integer('assigned_by')->length(11);
				$table->integer('reports')->length(5)->nullable(); // create table _reported_tags with col tag_id, _reported_by, _reason
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
        Schema::dropIfExists('tags');
        Schema::dropIfExists('model_has_tags');
    }
}
