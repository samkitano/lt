<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimelinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timelines', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('author_id')->unsigned()->index();
            $table->string('attachment')->nullable;
            $table->mediumText('content');
            $table->integer('likes')->unsigned()->default(0);

			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('timelines');
	}

}
