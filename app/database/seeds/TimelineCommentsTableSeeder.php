<?php


class TimelineCommentsTableSeeder extends Seeder {

public function run()
{
	DB::table('timeline_comments')->truncate();

		TimelineComment::create([
				'timeline_id'   => 3,
		        'user_id'       => 1,
		        'content'       => 'This is a comment',
		        'likes'         => 1,
		        'created_at'    => date("Y-m-d H:i:s"),
		        'updated_at'    => date("Y-m-d H:i:s")
                ]
		);
	}
}