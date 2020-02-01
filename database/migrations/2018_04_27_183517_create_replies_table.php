<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('replies')) {
			Schema::create('replies', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('comment_id')->unsigned();
				$table->foreign('comment_id')
					->references('id')
					->on('comments')
					->onDelete('cascade');
				$table->integer('re_reply')->unsigned()->nullable();
				$table->integer('author')->length(11);
				$table->text('text');
				$table->integer('votes')->length(11)->default(0);
				$table->timestamps();
				$table->softDeletes(); //add another table: deleted _by and _reason
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
        Schema::dropIfExists('replies');
    }
}
