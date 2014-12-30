<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password', 64);
            $table->string('password_temp', 64)->nullable();
            $table->string('remember_token')->nullable();
            $table->string('code', 64)->nullable();
            $table->boolean('active')->default(0);
            $table->boolean('banned')->default(0);

            $table->softDeletes();
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
		Schema::drop('users');
	}

}
