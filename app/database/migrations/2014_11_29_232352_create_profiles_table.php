<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id')->index()->unsigned();
            $table->tinyInteger('role')->default(7)->unsigned();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender', 1)->nullable();
            $table->string('profile_img')->nullable();
            $table->string('cover_img')->nullable();
            $table->string('punchline')->nullable();
            $table->string('about')->nullable();
            $table->date('birth')->nullable();
            $table->integer('reputation')->default(0)->unsigned();
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
		Schema::drop('profiles');
	}

}
