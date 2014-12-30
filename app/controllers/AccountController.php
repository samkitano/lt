<?php
/**
 * AccountController.php
 * Project: l4tests
 *
 * Author: Sam Kitano <samkitano@gmail.com>
 * Date: 21-04-2014
 * Time: 0:30
 */

class AccountController extends BaseController{

    public static function getCreate()
    {
        Session::flash('nav', 'login');
        return View::make('front.account.register');
    }

    public static function postCreate()
    {
        $validator = Validator::make(Input::all(), array(
            'username'  => 'required|min:3|max:20|unique:users',
            'email'     => 'required|email|max:50|unique:users',
            'first_name'=> 'required|alpha|min:3|max:20',
            'last_name' => 'required|alpha|min:3|max:20',
            'password'  => 'required|min:6',
            'confirm'   => 'required|same:password'
        ));

        if($validator->fails())
        {
            return Redirect::route('registar')
                ->withErrors($validator)
                ->withInput();
        }else{
            $username = Input::get('username');
            $email    = Input::get('email');
            $password = Input::get('password');

            // Activation Code
            $code = str_random(60);
            $user = User::create(
                array(
                        'username'  => $username,
                        'email'     => $email,
                        'password'  => Hash::make($password),
                        'code'      => $code,
                        'active'    =>0
                )
            );
            $profile = Profile::create(
                array(
                    'user_id'       => $user->id,
                    'profile_img'   => 'profile-image.png',
                    'cover_img'     => 'cover.png',
                    'first_name'    => Input::get('first_name'),
                    'last_name'     => Input::get('last_name')
                )
            );

            if($user && $profile)
            {
                // Send Email
                Mail::send('emails.auth.activate',
                    array(
                        'link'      => URL::route('account-activate', $code),
                        'code'      => $code,
                        'username'  => $username
                    ),
                    function($message) use ($user)
                    {
                        $message->to($user->email, $user->username)
                                ->subject('Livetuga - Ativa a tua conta');
                    }
                );
                return Redirect::route('home')->with('success', 'Conta criada com sucesso! Verifica o teu email para ativares a tua conta.');
            }
            return Redirect::route('registar')->with('err', 'Erro ao criar a conta!');
        }
    }

    public static function getActivate($code)
    {
        $user = User::where('code', '=', $code)->where('active', '=', 0);

        if($user->count())
        {
            $user = $user->first();
            $user->active = 1;
            $user->code   = '';

            if($user->save())
            {
                return Redirect::route('home')->with('success', 'Conta ativada!'.PHP_EOL.'Efectua o login com o teu Username e Password.');
            }
            return Redirect::route('home')->with('err', 'Erro ao ativar a conta.');
        }
    }

    public static function getLogIn()
    {
        Session::flash('nav', 'login');
        return View::make('front.account.login');
    }

    public static function postSignIn()
    {
        $validator = Validator::make(Input::all(), array(
            'username'  => 'required|min:3|max:20',
            'password'  => 'required|min:6'
        ));

        if($validator->fails())
        {
            return Redirect::route('login')
                ->withErrors($validator)
                ->withInput();
        }
        else
        {
            $username = Input::get('username');
            $password = Input::get('password');
            $remember = Input::has('remember') ? true : false;
            //$auth = Hash::check(Input::get('password'), Hash::make('Champion1'));dd($auth);
            $auth     = Auth::attempt(
                array(
                    'username' => $username,
                    'password' => $password,
                    'active'   => 1,
                    'banned'   => 0
                )//, $remember
            );
            if($auth)
            {
                $user = User::find(Auth::user()->id);
                if ($user->banned) return Redirect::route('login')->with('err', 'Esta conta está banida!');
                return Redirect::intended('/')->with('success', 'Login efetuado com sucesso!');
            }
            return Redirect::route('login')->with('err', 'Os dados inseridos estão errados ou a conta não foi ativada.');
        }
    }

    public static function getSignOut()
    {
        Auth::logout();
        Session::flush();
        return Redirect::route('home');
    }

    public static function getChangePassword()
    {
        return View::make('account.edit-password')->with('nav', 'dropdown');
    }

    public static function postChangePassword()
    {
        $validator = Validator::make(Input::all(), array(
            'old_password'  => 'required|min:6',
            'password'      => 'required|min:6',
            'confirm'       => 'same:password'
        ));

        if($validator->fails())
        {
            return Redirect::route('account-change-password')->withErrors($validator);
        }
        else
        {
            $user        = User::find(Auth::user()->id);
            $oldPassword = Input::get('old_password');
            $newPassword = Input::get('password');

            if(Hash::check($oldPassword, $user->getAuthPassword()))
            {
                $user->password = Hash::make($newPassword);

                if($user->save())
                {
                    Session::flush();
                    Auth::logout();
                    return Redirect::route('login')->with('success', 'A tua password foi alterada. Faz login com a tua nova password.');
                }
            }
            else
            {
                return Redirect::back()->with('err', 'A tua password antiga está incorreta!');
            }
        }
        return Redirect::back()->with('err', 'Não foi possível alterar a tua password.');
    }

    public static function getEmailChange()
    {
        return View::make('account.edit-email');
    }

    public static function putEmailChange()
    {
        $user       = User::find(Auth::user()->id);
        $user_email = $user->email;

        $validator  = Validator::make(Input::all(),
            array(
                'old_email' => 'required|email',
                'email'     => 'required|email'
            )
        );

        if($validator->fails()) return Redirect::back()->withErrors($validator);

        $old = Input::get('old_email');
        $new = Input::get('email');

        if($old != $user_email) return Redirect::back()->with('err', 'Email antigo incorreto!');
        if($old == $new)        return Redirect::back()->with('err', 'Ambos endereços iguais!');

        $user->email = $new;
        $user->save();

        return Redirect::route('profile')->with('success', 'Email alterado com sucesso!');
    }

    public static function getResetAccount()
    {
        return View::make('front.account.reset')->with('nav', 'signin');
    }

    public static function postResetAccount()
    {
        $validator = Validator::make(Input::all(),
            array('email'  => 'required|email')
        );

        if($validator->fails())
        {
            return Redirect::route('account-reset')->withErrors($validator);
        }
        else
        {
            $user = User::where('email', '=', Input::get('email'));
            if($user->count())
            {
                $user                = $user->first();
                $code                = str_random(60);
                $pass                = str_random(10);
                $user->code          = $code;
                $user->password_temp = Hash::make($pass);

                if($user->save())
                {
                    // Send Email
                    Mail::send('emails.auth.reset',
                        array('link' => URL::route('account-recover', $code),
                              'code' =>$code,
                              'username' => $user->$username,
                              'password' => $pass
                        ),
                        function($message) use ($user)
                        {
                            $message->to($user->email, $user->username)->subject('Reposição de password');
                        }
                    );
                    return Redirect::route('home')->with('success', 'Verifica o teu email e segue as instruções.');
                }
            }
        }

        return Redirect::route('account-reset')->with('err', 'Não foi possível alterar a password');
    }

    public static function getRecoverAccount($code)
    {
        $user = User::where('code', '=', $code)->where('password_temp', '!=', '');
        if($user->count())
        {
            $user                = $user->first();
            $user->password      = $user->password_temp;
            $user->password_temp = '';
            $user->code          = '';

            if($user->save()) return Redirect::route('home')->with('success', 'A tua conta foi recuperada. Podes efetuar o login com a tua nova password.');
        }
        return Redirect::route('home')->with('err', 'Não foi possível recuperar a password.');
    }

    public static function getEditProfile($id) {
        $profile = Profile::where('user_id', $id)->first();
        return View::make('front.account.settings')->with(compact('profile'));
    }

    public static function putEditProfile($id)
    {
        $dest_avatar = "img/profile/avatar/";
        $dest_cover  = "img/profile/cover/";
        $mime1       = 'image/jpeg';
        $mime2       = 'image/png';
        $profile_img = Input::hasFile('profile_img') ? Input::file('profile_img')  : false;
        $cover_img   = Input::hasFile('cover_img')   ? Input::file('cover_img')    : false;
        $profileName = $profile_img == false         ? false                       : $profile_img->getClientOriginalName();
        $coverName   = $cover_img   == false         ? false                       : $cover_img->getClientOriginalName();
        $profileSize = $profile_img == false         ? false                       : File::size($profile_img);
        $coverSize   = $cover_img   == false         ? false                       : File::size($cover_img);
        $profileMime = $profile_img == false         ? false                       : $profile_img->getMimeType();
        $coverMime   = $cover_img   == false         ? false                       : $cover_img->getMimeType();
        $profileExt  = false;
        $coverExt    = false;

        if($profile_img && $profileSize > 2097152)
            return Redirect::back()->with("err", "A imagem de perfil não pode ter mais de 2 MB");
        if($cover_img && $coverSize   > 2097152)
            return Redirect::back()->with("err", "A imagem de capa não pode ter mais de 2 MB");
        if($profile_img && $profileMime != $mime1 && $profileMime != $mime2)
            return Redirect::back()->with('err', 'A imagem de perfil deve ter a extensão «jpg» ou «png».');
        if($cover_img && $coverMime != $mime1 && $coverMime != $mime2)
            return Redirect::back()->with('err', 'A imagem de capa deve ter o formato «jpg» ou «png».');

        if($profileMime == $mime1) $profileExt = 'jpg';
        elseif($profileMime == $mime2) $profileExt = 'png';

        if($coverMime == $mime1) $coverExt = 'jpg';
        elseif($coverMime == $mime2) $coverExt = 'png';

        $up_avatar = $profile_img ? $profile_img -> move($dest_avatar, 'avatar_' . $id . '.' . $profileExt) : null;
        $up_cover  = $cover_img   ? $cover_img   -> move($dest_cover,  'cover_'  . $id . '.' . $coverExt)   : null;

        if($up_avatar === false) return Redirect::back()->with('err', 'Não foi possível realizar o upload da imagem de perfil!');
        if($up_cover === false)  return Redirect::back()->with('err', 'Não foi possível realizar o upload da imagem de capa!');

        $u = User::where('username', $id)->first();
        $profile = $u->profile;

        //ddump($user);

        if($profile_img)  $profile->profile_img = 'avatar_' . $id . '.' . $profileExt;
        if($cover_img)    $profile->cover_img   = 'cover_'  . $id . '.' . $coverExt;
        $profile->first_name = Input::get('first_name');
        $profile->last_name  = Input::get('last_name');
        $profile->punchline  = Input::get('punchline');


        //$profile->role       = 7;
        $save = $profile->save();

        if(!$save) return Redirect::back()->with('err', 'Não foi possível realizar as alterações');
        //ddump($profile);
        return Redirect::route('profile', $id)->with('success', 'Alterações efetuadas com sucesso!');
    }
}