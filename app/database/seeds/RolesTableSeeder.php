<?php


class RolesTableSeeder extends Seeder {

	public function run()
	{
        DB::table('roles')->truncate();

        Role::create([
            'role_id'   => 0,
            'role'      => 'Root',
            'created_at' => '2014-05-03 00:17:46',
            'updated_at' => '2014-05-03 00:17:46'
        ]);
        Role::create([
            'role_id'   => 1,
            'role'      => 'Administrador',
            'created_at' => '2014-05-03 00:17:53',
            'updated_at' => '2014-05-03 00:17:53'
        ]);
        Role::create([
            'role_id'   => 2,
            'role'      => 'Super Moderador',
            'created_at' => '2014-05-03 00:17:59',
            'updated_at' => '2014-05-03 00:17:59'
        ]);
        Role::create([
            'role_id'   => 3,
            'role'      => 'Moderador',
            'created_at' => '2014-05-03 00:18:06',
            'updated_at' => '2014-05-03 00:18:06'
        ]);
        Role::create([
            'role_id'   => 4,
            'role'      => 'Helper',
            'created_at' => '2014-05-03 00:18:18',
            'updated_at' => '2014-05-03 00:18:18'
        ]);
        Role::create([
            'role_id'   => 5,
            'role'      => 'Uploader',
            'created_at' => '2014-05-03 00:18:33',
            'updated_at' => '2014-05-03 00:18:33'
        ]);
        Role::create([
            'role_id'   => 6,
            'role'      => 'Premium',
            'created_at' => '2014-05-03 00:18:49',
            'updated_at' => '2014-05-03 00:18:49'
        ]);
        Role::create([
            'role_id'   => 7,
            'role'      => 'Utilizador',
            'created_at' => '2014-05-03 00:18:55',
            'updated_at' => '2014-05-03 00:18:55'
        ]);
    }

}
