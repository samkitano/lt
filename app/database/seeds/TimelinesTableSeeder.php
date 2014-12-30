<?php
class TimelinesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('timelines')->truncate();

        Timeline::create([
            'user_id'           => 1,
            'author_id'         => 1,
            'content'           => 'This is a post',
            'likes'             => 2,
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s")
			]);

		Timeline::create([
             'user_id'           => 2,
             'author_id'         => 2,
             'content'           => 'This is another post with comments',
             'likes'             => 5,
             'created_at'        => date("Y-m-d H:i:s"),
             'updated_at'        => date("Y-m-d H:i:s")
         ]);
	}

}