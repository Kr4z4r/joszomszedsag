<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends VerifyEmailNotification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
      $verificationUrl = $this->verificationUrl($notifiable);
  
      if (static::$toMailCallback) {
        return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
      }
  
      return (new MailMessage)
        ->subject(Lang::get('Regisztráció megerősítése - '.config('app.name')))
        ->line(Lang::get('A regisztráció folytatásához erősítse meg e-mail címét! Kattintson az alábbi gombra:'))
        ->action(Lang::get('E-mail cím megerősítése'), $verificationUrl)
        ->line(Lang::get('Ha nem Ön hozta létre a felhasználót, akkor kérem jelezze felénk!'));
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
