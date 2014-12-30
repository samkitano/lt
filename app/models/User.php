<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use SoftDeletingTrait;
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'password_temp', 'remember_token');

    protected $dates     = ['deleted_at'];
    protected $fillable  = [
        'email',
        'username',
        'password',
        'password_temp',
        'remember_token',
        'code',
        'active',
        'banned',
    ];
    protected $guarded = [
        'id',
    ];

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public static function getUserData()
    {
        $ret = false;
        if(Auth::check()){
            $id                 = Auth::user()->id;
            $ret                = array();
            $user               = User::find($id);
            $ret['id']          = $user->id;
            $ret['userNum']     = User::all()->count();
            $ret['username']    = $user -> username;
            $ret['email']       = $user -> email;
            //$prof               = Profile::where('user_id', $id)->first();
            $ret['nome']        = $user->profiles->first_name;
            $ret['apelido']     = $user->profiles->last_name;
            $ret['punchline']   = $user->profiles->punchline;
            $ret['reputation']  = $user->profiles->reputation;
            $ret['profile_img'] = $user->profiles->profile_img;
            $ret['cover_img']   = $user->profiles->cover_img;
        }
        return $ret;
    }

    public static function getThatUser($uname)
    {
        $user = User::where('username', $uname)->first();
        //$id   = $user->id;

        $ret['username']    = $user->username;
        $ret['email']       = $user->email;
        //$prof               = Profile::where('uid', $id)->first();
        $ret['nome']        = $user->profiles->first_name;
        $ret['apelido']     = $user->profiles->last_name;
        $ret['punchline']   = $user->profiles->punchline;
        $ret['reputation']  = $user->profiles->reputation;
        $ret['profile_img'] = $user->profiles->profile_img;
        $ret['cover_img']   = $user->profiles->cover_img;

        return $ret;
    }


    public function profiles()
    {
        return $this->hasOne('Profile');
    }

    public function friends()
    {
        return $this->hasMany('Friend');
    }

    public function timelines()
    {
        return $this->hasMany('Timeline')->orderBy('created_at', 'desc');
    }
}

