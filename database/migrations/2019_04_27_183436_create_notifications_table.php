<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('notifications')) {
			Schema::create('notifications', function (Blueprint $table) {
				$table->increments('id');
				$table->string('type');
				$table->string('related_model')->nullable();
				$table->integer('related_model_id')->nullable();
				$table->integer('from');
				$table->integer('from_more')->default(0);
				$table->morphs('notifiable');
				//$table->integer('at_post_id')->nullable();
				$table->string('text', 255);
				$table->string('url_params', 255)->nullable();
				$table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
