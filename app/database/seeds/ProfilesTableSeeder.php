<?php

// Composer: "fzaninotto/faker": "v1.3.0"

class ProfilesTableSeeder extends Seeder {

	public function run()
	{
        DB::table('profiles')->truncate();

        Profile::create([
            'user_id'       =>  1,
            'role'          =>  0,
            'first_name'    =>  'João',
            'last_name'     =>  'Caetano',
            'gender'        =>  'M',
            'profile_img'   =>  'avatar_ThePaparranas.jpg',
            'cover_img'     =>  'cover_ThePaparranas.png',
            'birth'         =>  '1994/01/17',
        ]);

		Profile::create([
            'user_id'       =>  2,
            'role'          =>  0,
            'first_name'    =>  'Sam',
            'last_name'     =>  'Kitano',
            'gender'        =>  'M',
            'profile_img'   =>  'profile-image.png',
            'cover_img'     =>  'cover_default.png',
            'birth'         =>  '1963/01/28',
        ]);
    }

}