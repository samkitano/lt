<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimelineCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timeline_comments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('timeline_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->string('attachment')->nullable();
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
		Schema::drop('timeline_comments');
	}

}
