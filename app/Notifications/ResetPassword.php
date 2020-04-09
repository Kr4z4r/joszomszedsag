<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends ResetPasswordNotification
{
    use Queueable;
  
  /**
   * Create a new notification instance.
   *
   * @param $token
   */
  public function __construct($token) {
    parent::__construct($token);
  }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }
  
  /**
   * Build the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable) {
    if (static::$toMailCallback) {
      return call_user_func(static::$toMailCallback, $notifiable, $this->token);
    }
    
    if (static::$createUrlCallback) {
      $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
    } else {
      $url = url(config('app.url').route('password.reset', [
          'token' => $this->token,
          'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }
    
    return (new MailMessage)
      ->subject(Lang::get('Jelszó visszaállítási kérelem - '.config('app.name')))
      ->line(Lang::get('Azért kapja Ön ezt az emailt, mert a felhasználójához egy kérelem lett elküldve weboldalunkon.'))
      ->action(Lang::get('Jelszó visszaállítása'), $url)
      ->line(Lang::get('A jelszó visszaállításához használható link :count perc múlva lejár', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
      ->line(Lang::get('Ha nem Ön küldte a kérelmet, akkor törölje az emailt!'));
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
