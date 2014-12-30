<?php

class TimelineComment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

    protected $table = 'timeline_comments';

    public function timeline()
    {
        return $this->belongsTo('Timeline');
    }
}