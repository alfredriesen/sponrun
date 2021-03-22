<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends Notification
{
    use Queueable;

    private $confirmationCode;

	private $isEmailUpdate;

	/**
	 * @var string
	 */
	private $oldMail;

	/**
	 * Create a new notification instance.
	 *
	 * @param string $confirmationCode
	 * @param bool $isEmailUpdate
	 * @param string $oldMail
	 */
    public function __construct(string $confirmationCode, bool $isEmailUpdate = false, string $oldMail = '')
    {
		$this->oldMail = $oldMail;
		$this->isEmailUpdate = $isEmailUpdate;
        $this->confirmationCode = $confirmationCode;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		$email = $this->isEmailUpdate ? $this->oldMail : $notifiable->getEmailForPasswordReset();
		$link = route('register.verify', $this->confirmationCode) . '?email=' . urlencode($email);
		return (new MailMessage())->subject('E-Mail-Adresse bestätigen')
			->line($this->isEmailUpdate ? 'Du erhältst diese E-Mail, weil du Deine E-Mail-Adresse auf unserer Website aktualisiert hast.': 'Du erhältst diese E-Mail, weil diese E-Mail-Adresse auf unserer Website zur Registrierung angegeben wurde.')
			->line($this->isEmailUpdate ? 'Bitte bestätige Deine neue E-Mail-Adresse:' : 'Wenn Du Deinen Account freischalten möchtest, bestätige bitte Deine E-Mail:')
			->action('E-Mail-Adresse bestätigen', $link)
			->line('Wenn Du dich nicht auf unserer Website registriert hast, solltest Du die E-Mail nicht bestätigen.');
	}

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
