<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('links')) {
			Schema::create('links', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('text_a')->length(11);
				$table->integer('text_b')->length(11);
				$table->integer('author')->length(11);
				$table->integer('reports')->length(5); // create table _reported_links with col link_id, _reported_by, _reason
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
        Schema::dropIfExists('links');
    }
}
