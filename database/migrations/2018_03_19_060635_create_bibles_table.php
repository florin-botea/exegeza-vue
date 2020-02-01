<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('bibles')) {
			Schema::create('bibles', function (Blueprint $table) {
					$table->increments('id');
					$table->string('name')->length(60);
					$table->string('alias')->length(10);
					$table->string('slug')->length(10);
					$table->boolean('public')->default(false);
			});
		}
		if (!Schema::hasTable('books')) {
			Schema::create('books', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('bible_id')->unsigned();
					$table->foreign('bible_id')
						->references('id')
						->on('bibles')
						->onDelete('cascade');
					$table->integer('index')->length(11);
					$table->string('name')->length(60);
					$table->string('slug')->length(25);
			});
		}
		if (!Schema::hasTable('chapters')) {
			Schema::create('chapters', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('book_id')->unsigned();
					$table->foreign('book_id')
						->references('id')
						->on('books')
						->onDelete('cascade');
					//$table->integer('book_index')->unsigned();
					$table->integer('index');
					$table->string('text')->length(60);
			});
		}
		// if (!Schema::hasTable('verses')) {
			// Schema::create('verses', function (Blueprint $table) {
					// $table->increments('id');
					// $table->integer('chapter_id')->unsigned();
					// $table->foreign('chapter_id')
						// ->references('id')
						// ->on('chapters')
						// ->onDelete('cascade');
					// $table->integer('index');
					// $table->string('text')->length(700);
			// });

		// }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bibles');
        Schema::dropIfExists('books');
        Schema::dropIfExists('chapters');
    }
}
