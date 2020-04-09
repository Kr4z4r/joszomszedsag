<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use TCG\Voyager\Facades\Voyager;

class WelcomeEmail extends Notification
{
  private $user;
  use Queueable;
  
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($user)
  {
    $this->user = $user;
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
   * @return \Illuminate\Notifications\Messages\MailMessage|bool
   */
  public function toMail($notifiable)
  {
    if($this->user->role_id == 7) return true;
    $site_title = Voyager::setting('site.title') ?? config('app.name');
    return (new MailMessage)
      ->subject(Lang::get('Fontos tudnivalók - '.$site_title))
      ->greeting(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
      ->line(Lang::get('Köszönjük regisztrációját!'))
      ->line(Lang::get('Csatolva megtalálja a szükséges információkat'))
      ->attach(public_path('files/leiras.pdf'),[
        'as' => 'leiras.pdf',
        'mime' => 'application/pdf',
      ])->attach(public_path('files/felepites.pdf'),[
        'as' => 'felepites.pdf',
        'mime' => 'application/pdf',
      ]);
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
