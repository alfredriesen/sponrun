<?php

namespace App\Domain\Model\Auth;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;

class User extends Authenticatable implements MustVerifyEmail
{

	use EntrustUserTrait;
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'firstname', 'lastname',
		'street', 'housenumber',
		'postcode', 'city',
		'birthday', 'phone', 'gender',
		'password', 'wants_newsletter'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token', 'confirmation_code'
	];
	
	/**
	 * The attributes that should converted into date.
	 *
	 * @var array
	 */
	protected $dates = [
		'created_at', 'updated_at', 'birthday'
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	// Auth:: = AuthManager > SessionGuard > EloquentUserProvider > User

	public function getBirthdayAttribute($birthday)
	{
		Carbon::setToStringFormat('Y-m-d');
		return new Carbon($birthday);
	}

	public function generateToken()
	{
		$this->api_token = str_random(60);
		$this->save();
		
		return $this->api_token;
	}
	
	
	/**
	 * {@inheritDoc}
	 * @see \Illuminate\Contracts\Auth\CanResetPassword::sendPasswordResetNotification()
	 */
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPassword($token));
		Session::flash('messages-success', new MessageBag(["Dir wurde eine Mail zugeschickt"]));
	}
}
