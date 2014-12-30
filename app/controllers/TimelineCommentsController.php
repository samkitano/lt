<?php

class TimelineCommentsController extends \BaseController {

	/**
	 * Display a listing of timelinecomments
	 *
	 * @return Response
	 */
	public function index()
	{
		$timelinecomments = Timelinecomment::all();

		return View::make('timelinecomments.index', compact('timelinecomments'));
	}

	/**
	 * Show the form for creating a new timelinecomment
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('timelinecomments.create');
	}

	/**
	 * Store a newly created timelinecomment in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Timelinecomment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Timelinecomment::create($data);

		return Redirect::route('timelinecomments.index');
	}

	/**
	 * Display the specified timelinecomment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$timelinecomment = Timelinecomment::findOrFail($id);

		return View::make('timelinecomments.show', compact('timelinecomment'));
	}

	/**
	 * Show the form for editing the specified timelinecomment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$timelinecomment = Timelinecomment::find($id);

		return View::make('timelinecomments.edit', compact('timelinecomment'));
	}

	/**
	 * Update the specified timelinecomment in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$timelinecomment = Timelinecomment::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Timelinecomment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$timelinecomment->update($data);

		return Redirect::route('timelinecomments.index');
	}

	/**
	 * Remove the specified timelinecomment from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Timelinecomment::destroy($id);

		return Redirect::route('timelinecomments.index');
	}

}
