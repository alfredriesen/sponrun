<?php

namespace App\Domain\Model\Sponsor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;

class Sponsor extends Model
{

	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'firstname', 'lastname',
		'street', 'housenumber',
		'postcode', 'city', 'phone',
		'email', 'donation_per_lap',
		'donation_static_max', 'wants_newsletter'
	];
	protected $dates = [
		'created_at', 'updated_at', 'begin'
	];

	public function user()
	{
		return $this->belongsTo('App\Domain\Model\Auth\User');
	}

	public function runParticipation()
	{
		return $this->belongsTo('App\Domain\Model\Sponsor\RunParticipation');
	}

	public function calculateDonationSum($laps)
	{
		$donation = $this->donation_per_lap * $laps;
		if ($this->donation_static_max == 0) {
			return $donation;
		} elseif ($this->donation_per_lap == 0) {
			return $this->donation_static_max;
		} else {
			return $donation > $this->donation_static_max ? $this->donation_static_max : $donation;
		}
	}

	public function setDonationPerLapAttribute($donation_per_lap)
	{
		$this->attributes['donation_per_lap'] = $donation_per_lap == NULL ? 0 : $donation_per_lap;
	}

	public function setDonationStaticMaxAttribute($donation_static_max)
	{
		$this->attributes['donation_static_max'] = $donation_static_max == NULL ? 0 : $donation_static_max;
	}

	public static function validator(array $data)
	{
		return Validator::make($data, [
					'firstname' => 'required|max:255',
					'lastname' => 'required|max:255',
					'street' => 'required|max:255',
					'housenumber' => 'required|string|max:31',
					'postcode' => 'required|numeric|between:0,99999',
					'city' => 'required|max:255',
					'phone' => 'nullable|phone:AUTO,DE',
					'email' => 'nullable|email|max:255',
					'donation_per_lap' => ['nullable', 'required_without:donation_static_max', 'regex:/^\d+[,.]?\d{0,2}$/', 'max:10'],
					'donation_static_max' => ['nullable', 'required_without:donation_per_lap', 'regex:/^\d+[,.]?\d{0,2}$/', 'max:10'],
					'wants_newsletter' => 'boolean'
		]);
	}

	/**
	 * Get the sponsor's full name.
	 *
	 * @return string
	 */
	public function getFullnameAttribute()
	{
		return "{$this->firstname} {$this->lastname}";
	}
}
