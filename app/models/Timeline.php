<?php

class Timeline extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [
		'attachment',
	    'content',
	    'likes',
	];

	protected $guarded = ['$id', 'user_id', '$author_id'];

    protected $table = 'timelines';

    public function timelineComments()
    {
        return $this->hasMany('TimelineComment');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

	public function author()
	{
		return $this->belongsTo('User');
	}
}