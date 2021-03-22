<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewSponsor extends Notification
{
	use Queueable;

	private $sponsorName;
	private $donation_per_lap;
	private $donation_static_max;
	/**
	 * @var bool
	 */
	private $sponsorNotification;
	/**
	 * @var string
	 */
	private $usersFullname;

	/**
	 * Create a new notification instance.
	 *
	 * @param $sponsorName
	 * @param $donation_per_lap
	 * @param $donation_static_max
	 * @param bool $sponsorNotification
	 * @param string $usersFullname
	 */
	public function __construct($sponsorName, $donation_per_lap, $donation_static_max, bool $sponsorNotification = false, string $usersFullname = '')
	{
		$this->sponsorName = $sponsorName;
		$this->donation_per_lap = $donation_per_lap;
		$this->donation_static_max = $donation_static_max;
		$this->sponsorNotification = $sponsorNotification;
		$this->usersFullname = $usersFullname;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return [
			'mail'
		];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		$value='';
		if ($this->donation_per_lap != 0) {
			$value.=number_format($this->donation_per_lap, 2, ',', '').' € pro Runde';
			if ($this->donation_static_max != 0) {
				$value.=', aber insgesamt maximal '.number_format($this->donation_static_max, 2, ',', '').' €.';
			} else {
				$value.= '.';
			}
		} else {
			$value.='insgesamt '.number_format($this->donation_static_max, 2, ',', '').' €.';
		}
		return (new MailMessage())->subject($this->sponsorNotification ? "Sponsor für {$this->usersFullname}" : 'Neuer Sponsor')
			->line($this->sponsorNotification ? 'Du bist Sponsor, danke!': 'Du hast einen neuen Sponsor!')
			->line(($this->sponsorNotification ? "Du unterstützt {$this->usersFullname}" : "{$this->sponsorName} hat sich als Sponsor für dich eingetragen") . " mit einem Betrag von {$value}");
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [ //
		];
	}
}
