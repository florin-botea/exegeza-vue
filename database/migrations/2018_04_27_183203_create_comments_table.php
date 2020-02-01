<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('comments')) {
			Schema::create('comments', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('target')->length(11);
				$table->integer('author')->length(11);
				$table->string('title', 120);
				$table->text('text');
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
        Schema::dropIfExists('comments');
    }
}
