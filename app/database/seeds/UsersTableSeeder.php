<?php


class UsersTableSeeder extends Seeder {

	public function run()
	{
        DB::table('users')->truncate();

        User::create([
            'email'             =>      'ThePaparranas@hotmail.com',
            'username'          =>      'ThePaparranas',
            'active'            =>      1,
            'password'          =>      '$2y$10$jViS7BO51LTxnflnrjvmyOf41pDhEDqZpRrqYkTR5iCJYHcM3EMtq',
        ]);

		User::create([
			             'email'             =>      'sam.kitano@gmail.com',
			             'username'          =>      'Samy',
			             'active'            =>      1,
			             'password'          =>      Hash::make('B0rr3g0'),
		             ]);
    }
}