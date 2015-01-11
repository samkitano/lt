<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

    public function home() {
        Session::flash('nav', 'home');
        return View::make('front.home.home');
    }

    public function teste() {
        Session::flash('nav', 'teste');
        return View::make('front.teste');
    }

    public function welcome() {
        Session::flash('nav', 'welcome');
        return View::make('front.welcome');
    }

    public function cronologia($uname) {


        Session::flash('nav', 'cronologia');

        return View::make('front.cronologia');
    }

	public function ajaxTimeline()
	{
		if( ! Request::ajax())
		{
			return Response::json(array('error' => '403'));
		}

		$uname = Request::get('user');

		$user  = User::where('username', $uname)->first();

		//return $user;
		return json_encode($user, JSON_UNESCAPED_UNICODE);
	}

	public function ajaxSendPost()
	{
		//var_dump(Input::all());
		if( ! Request::ajax())
		{
			return Response::json(array('error' => '403'));
		}

		$data               = array_except(Input::all(), '_token') ;
		$nwPost             = new Timeline;
		$nwPost->user_id    = $data['user'];
		$nwPost->author_id  = $data['author'];
		$nwPost->content    = $data['content'];

		$saved = $nwPost->save();

		if (! $saved)
		{
			Response::json(array('success' => 0));
		}

		return json_encode($nwPost, JSON_UNESCAPED_UNICODE);
	}

    public static function filmes() {
        Session::flash('nav', 'filmes');
        return View::make('front.filmes');
    }

    public static function himym() {
        return View::make('front.filme-info');
    }

    public static function series() {
        Session::flash('nav', 'series');
        return View::make('front.series');
    }

    public static function animes() {
        Session::flash('nav', 'animes');
        return View::make('front.animes');
    }

    public static function noticias() {
        Session::flash('nav', 'noticias');
        return View::make('front.noticias');
    }

    public static function filme() {
        return View::make('front.filme');
    }

    public static function serie() {
        return View::make('front.serie');
    }

    public static function noticia() {
        return View::make('front.noticia');
    }

    public static function locked() {
        return View::make('front.locked');
    }

    public static function profile($uname) {
	    $utilizador = User::getThatUser($uname);
	    $this_user  = User::where('username', $uname)->first();
	    $this_user_posts = Timeline::where('user_id', $this_user->id)->paginate(10);
        //ddump($user);
        Session::flash('nav', 'profile');
        return View::make('front.profile.cronologia')
	        ->with('the_user', $this_user)
	        ->with(compact('utilizador'))
	        ->with('posts', $this_user_posts);
    }

    public static function amigos($uname) {
        $utilizador = User::getThatUser($uname);
        //ddump($user);
        Session::flash('nav', 'amigos');
        return View::make('front.profile.amigos')->with(compact('utilizador'));
    }

    public static function favoritos($uname) {
        $utilizador = User::getThatUser($uname);
        //ddump($user);
        Session::flash('nav', 'favoritos');
        return View::make('front.profile.favoritos')->with(compact('utilizador'));
    }

    public static function email() {
        return View::make('account.edit-email');
    }

	public static function ajaxSendEditedPost($id)
	{
		//dd(Input::all());
		if (Request::ajax())
		{
			$post = Timeline::find($id);
			$post->content = Input::get('content');
			$post->save();

			return Response::json('OK', 200);
		}
		else
		{
			return Response::json('FORBIDDEN', 403);
		}
	}

	public static function ajaxDeletePost($id)
	{
		if(Request::ajax())
		{
			$del = Timeline::destroy($id);

			return Response::json('OK', 200);
		}
		else
		{
			return Response::json('FORBIDDEN', 403);
		}
	}
}
