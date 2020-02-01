<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('votes')) {
			Schema::create('votes', function (Blueprint $table) {
				$table->integer('user')->length(11);
				$table->integer('reply_id')->unsigned();
				$table->foreign('reply_id')
					->references('id')
					->on('replies')
					->onDelete('cascade');
				$table->tinyInteger('vote');
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
        Schema::dropIfExists('votes');
    }
}
