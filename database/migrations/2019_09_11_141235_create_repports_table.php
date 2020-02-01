<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('repports')) {
			Schema::create('repports', function (Blueprint $table) {
				$table->increments('id');
				$table->string('model_type', 63);
				$table->unsignedInteger('model_id');
				$table->unsignedInteger('repported_by');
				$table->string('reason', 255);
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
        Schema::dropIfExists('repports');
    }
}
