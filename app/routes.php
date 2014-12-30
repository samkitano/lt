<?php
/*$p = Hash::make('Champion1');
die($p) ;*/
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/',                         ['as' => 'home',                'uses' => 'HomeController@home']);
    Route::get('/filmes',                    ['as' => 'filmes',              'uses' => 'HomeController@filmes']);
    Route::get('/filme/himym',               ['as' => 'himym',               'uses' => 'HomeController@himym']);
    Route::get('/series',                    ['as' => 'series',              'uses' => 'HomeController@series']);
    Route::get('/animes',                    ['as' => 'animes',              'uses' => 'HomeController@animes']);
    Route::get('/noticias',                  ['as' => 'noticias',            'uses' => 'HomeController@noticias']);
    Route::get('/registar',                  ['as' => 'registar',            'uses' => 'AccountController@getCreate']);
    Route::get('/account/activate/{code}',   ['as' => 'account-activate',    'uses' => 'AccountController@getActivate']);
    Route::get('/login',                     ['as' => 'login',               'uses' => 'AccountController@getLogIn']);
    Route::get('/account/reset',             ['as' => 'account-reset',       'uses' => 'AccountController@getResetAccount']);
    Route::get('/account/recover/{code}',    ['as' => 'account-recover',     'uses' => 'AccountController@getRecoverAccount']);
    Route::get('/teste',                     ['as' => 'teste',               'uses' => 'HomeController@teste']);

    // CSRF protection
    Route::group( ['before' => 'csrf'], function() {
        Route::post('/registar',            ['as' => 'registar',            'uses' => 'AccountController@postCreate']);
        Route::post('/login',               ['as' => 'login',               'uses' => 'AccountController@postSignIn']);
        Route::post('/account/reset',       ['as' => 'account-reset',       'uses' => 'AccountController@postResetAccount']);
    });

Route::group( ['before' => 'auth'], function() {
    Route::get('amigos/{uname}',            ['as' => 'amigos',              'uses' => 'HomeController@amigos']);
    Route::get('favoritos/{uname}',         ['as' => 'favoritos',           'uses' => 'HomeController@favoritos']);
    Route::get('filme',                     ['as' => 'filme',               'uses' => 'HomeController@filme']);
    Route::get('serie',                     ['as' => 'serie',               'uses' => 'HomeController@serie']);
    Route::get('noticia',                   ['as' => 'noticia',             'uses' => 'HomeController@noticia']);
    Route::get('conta/{id}/editar',         ['as' => 'conta',               'uses' => 'AccountController@getEditProfile']);
    Route::get('utilizador/{uname}',        ['as' => 'profile',             'uses' => 'HomeController@profile']);
    Route::get('{uname}/cronologia',        ['as' => 'cronologia',          'uses' => 'HomeController@cronologia']);
    Route::get('conta/email',               ['as' => 'change_email',        'uses' => 'AccountController@getEmailChange']);

	Route::get('ajx_posts', ['as' => 'ajx_posts', 'uses' => 'HomeController@ajaxTimeline']);
	Route::post('ajax_send_post', ['as' => 'ajax_send_post', 'uses' => 'HomeController@ajaxSendPost']);
	Route::patch('ajax_send_post/{id}', ['as' => 'ajax_send_edited_post', 'uses' => 'HomeController@ajaxSendEditedPost']);
	Route::delete('ajax_delete_post/{id}', ['as' => 'ajax_delete_post', 'uses' => 'HomeController@ajaxDeletePost']);
    //CSRF protection
    Route::group(['before' => 'csrf'], function() {
            // POST
            // Change password
            Route::post('/conta/password',        ['as' => 'account-change-password',   'uses' => 'AccountController@postChangePassword']);
            // PUT
            // Edit Account
            Route::put('/conta/{id}/editar',      ['as' => 'put_profile',               'uses' => 'AccountController@putEditProfile']);
            // PUT
            // Edit Email
            Route::put('/conta/email',       ['as' => 'put_email',            'uses' => 'AccountController@putEmailChange']);


            Route::post('timeline_post',     ['as' => 'timeline_post',        'uses' => 'TimelineController@store']);

            Route::post('timeline_comments', ['as' => 'timeline_comments',    'uses' => 'TimelineCommentsController@store']);

            Route::post('timeline_like',     ['as' => 'timeline_like',        'uses' => 'TimelineController@like']);

            Route::post('timeline_unlike',   ['as' => 'timeline_unlike',      'uses' => 'TimelineController@unlike']);

            Route::post('comment_like',      ['as' => 'comment_like',         'uses' => 'TimelineCommentsController@like']);

            Route::post('comment_unlike',    ['as' => 'comment_unlike',       'uses' => 'TimelineCommentsController@unlike']);

            Route::post('timeline_delete',   ['as' => 'timeline_delete',      'uses' => 'TimelineController@destroy']);

            Route::post('comment_delete',    ['as' => 'comment_delete',       'uses' => 'TimelineCommentsController@destroy']);

            Route::post('timeline_edit',    ['as' => 'timeline_edit',       'uses' => 'TimelineController@update']);

            Route::post('comment_edit',    ['as' => 'comment_edit',       'uses' => 'TimelineCommentsController@update']);
        }
    );
    // GET
    // Sign Out
    Route::get('logout',                    ['as' => 'logout',                    'uses' => 'AccountController@getSignOut']);
    // GET
    // Change password
    Route::get('/conta/password',           ['as' => 'account-change-password',   'uses' => 'AccountController@getChangePassword']);

    // VIEW
    // View Profile
    Route::get('/user/{username}',          ['as' => 'view-user',                 'uses' => 'ProfileController@viewUser']);

    /*
     * GET
     * Email
     */
});