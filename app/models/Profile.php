<?php

class Profile extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

    protected $table = 'profiles';

	// Don't forget to fill this array
	protected $fillable = [
        'user_id',
        'role',
        'first_name',
        'last_name',
        'gender',
        'profile_img',
        'cover_img',
        'punchline',
        'about',
        'birth',
        'reputation',
    ];

    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo('User');
    }
}